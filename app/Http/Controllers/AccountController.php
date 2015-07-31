<?php

namespace App\Http\Controllers;

use App\Account;
use App\User;
use Auth;
use Carbon\Carbon;
use Config;
use Illuminate\Http\Request;
use Session;

class AccountController extends Controller
{
    /**
     * Default account routing
     * @param  Illuminate\Http\Request $request Current request
     * @return Illuminate/Http/Response Redirection
     */
    public function getIndex(Request $request) {
        $account = Auth::user()->accounts()->first();

        // Redirect to first account if exists
        if ($account instanceof Account) {
            $request->session()->reflash();
            return redirect()->action('AccountController@getSummary', $account);
        }

        // Redirect to add form if no account exist for user
    }


    /**
     * Render add account form
     * @return Illuminate/Http/Response View to render
     */
    public function getAdd() {
        return view('account.add');
    }

    public function postAdd(Request $request) {
        $this->validate($request, [
            'name' => 'string|required',
        ]);

        $account = Account::create($request->only(['name']));
        Auth::user()->accounts()->save($account, ['owner' => 1]);

        return redirect()->action('AccountController@getSummary', $account)
            ->withSuccess(trans('account.add.successMessage', ['account' => $account]));
    }



    /**
     * Render update account form
     * @return Illuminate/Http/Response View to render
     */
    public function getUpdate($account_id) {
        $account = Auth::user()->accounts()->find($account_id);

        if (is_null($account) || $account->owner->first()->id !== Auth::user()->id) {
            return redirect()->action('AccountController@getIndex')
                ->withErrors(trans('account.index.notfoundMessage'));
        }

        $data = [
            'account' => $account,
        ];

        return view('account.update', $data);
    }

    public function postUpdate(Request $request, $account_id) {
        $account = Auth::user()->accounts()->find($account_id);

        if (is_null($account) || $account->owner->first()->id !== Auth::user()->id) {
            return redirect()->action('AccountController@getIndex')
                ->withErrors(trans('account.index.notfoundMessage'));
        }

        $this->validate($request, [
            'name' => 'string|required',
        ]);

        $account->fill($request->only(['name']));
        $account->save();

        return redirect()->action('AccountController@getSummary', $account)
            ->withSuccess(trans('account.update.successMessage', ['account' => $account]));
    }



    public function getDelete($account_id) {
        $account = Auth::user()->nontrashedAccounts()->find($account_id);

        if (is_null($account) || $account->owner->first()->id !== Auth::user()->id) {
            return redirect()->action('AccountController@getIndex')
                ->withErrors(trans('account.index.notfoundMessage'));
        }

        $account->delete();

        return redirect()->action('AccountController@getSummary', $account)
            ->withSuccess(trans('account.delete.successMessage', ['account' => $account]));
    }



    public function getRestore($account_id) {
        $account = Auth::user()->trashedAccounts()->find($account_id);

        if (is_null($account) || $account->owner->first()->id !== Auth::user()->id) {
            return redirect()->action('AccountController@getIndex')
                ->withErrors(trans('account.index.notfoundMessage'));
        }

        $account->restore();

        return redirect()->action('AccountController@getSummary', $account)
            ->withSuccess(trans('account.restore.successMessage', ['account' => $account]));
    }



    /**
     * Gather information about account for account home page (first tab)
     * @param  string $account_id Account ID
     * @return Illuminate/Http/Response View to render
     */
    public function getSummary($account_id) {
        $account = Auth::user()->accounts()->find($account_id);

        if (is_null($account)) {
            return redirect()->action('AccountController@getIndex')
                ->withErrors(trans('account.index.notfoundMessage'));
        }

        $balanceData = [
            [
                'label' => trans('outcome.effectiveTitle'),
                'value' => $account->effective_outcome,
            ],
            [
                'label' => trans('outcome.intendedTitle'),
                'value' => $account->intended_outcome,
            ],
            [
                'label' => trans('revenue.unallocatedTitle'),
                'value' => $account->unallocated_revenue,
            ],
            [
                'label' => trans('revenue.allocatedTitle'),
                'value' => $account->allocated_revenue,
            ],
        ];

        $envelopesData = [];
        $envelopesColors = [];
        foreach ($account->envelopes as $envelope) {
            $balance = $envelope->balance;

            $envelopesData[] = [
                'label' => $envelope->name,
                'value' => abs($balance),
                'negative' => $balance < 0,
            ];

            $envelopesColors[] = Config::get('budget.statusColors.'.$envelope->status);
        }

        $data = [
            'account' => $account,
            'activeTab' => 'summary',
            'balanceData' => json_encode($balanceData),
            'balanceColors' => json_encode(array_values(Config::get('budget.statusColors'))),
            'envelopesData' => json_encode($envelopesData),
            'envelopesColors' => json_encode($envelopesColors),
            'events' => $account->relatedEvents()->paginate(5),
        ];

        return view('account.summary', $data);
    }

    public function getAttachUser(Request $request, $account_id) {
        $request->session()->reflash();
        return redirect()->action('AccountController@getSummary', $account_id);
    }

    public function postAttachUser(Request $request, $account_id) {
        $account = Auth::user()->accounts()->find($account_id);

        if (is_null($account)) {
            return redirect()->action('AccountController@getIndex')
                ->withErrors(trans('account.index.notfoundMessage'));
        }

        $this->validate($request, [
            'email' => 'required|email|exists:users',
        ]);

        $user = User::where('email', $request->input('email'))->first();
        if ($user->id != $account->owner()->first()->id
            && $account->guests()->where('user_id', $user->id)->count() === 0) {
            $account->users()->attach($user->id);
        }

        return redirect()->action('AccountController@getSummary', $account)
                ->withSuccess(trans('account.users.attachUserMessage', ['user' => $user]));
    }

    public function postDetachUser(Request $request, $account_id) {
        $account = Auth::user()->accounts()->find($account_id);

        if (is_null($account)) {
            return redirect()->action('AccountController@getIndex')
                ->withErrors(trans('account.index.notfoundMessage'));
        }

        $user = User::find($request->input('user_id'));
        $account->guests()->detach($user->id);

        return redirect()->action('AccountController@getSummary', $account)
                ->withSuccess(trans('account.users.detachUserMessage', ['user' => $user]));
   }

    public function getRevenues($account_id) {
        $account = Auth::user()->accounts()->find($account_id);

        if (is_null($account)) {
            return redirect()->action('AccountController@getIndex')
                ->withErrors(trans('account.index.notfoundMessage'));
        }

        $data = [
            'account' => $account,
            'activeTab' => 'revenues',
        ];

        return view('account.revenues', $data);
    }



    /**
     * List operations related to one account (second tab)
     * @param  string $account_id Account ID
     * @return Illuminate/Http/Response View to render
     */
    public function getOutcomes($account_id) {
        $account = Auth::user()->accounts()->find($account_id);

        if (is_null($account)) {
            return redirect()->action('AccountController@getIndex')
                ->withErrors(trans('account.index.notfoundMessage'));
        }

        $data = [
            'account' => $account,
            'activeTab' => 'outcomes',
        ];

        return view('account.outcomes', $data);
    }



    /**
     * Show charts about account development (third tab)
     * @param  string $account_id Account ID
     * @return Illuminate/Http/Response View to render
     */
    public function getDevelopment($account_id, $month = null, $year = null) {
        $account = Auth::user()->accounts()->find($account_id);

        if (is_null($account)) {
            return redirect()->action('AccountController@getIndex')
                ->withErrors(trans('account.index.notfoundMessage'));
        }

        $month = is_null($month) ? Carbon::today() : Carbon::createFromFormat('Y-m-d', $month);
        $month->startOfMonth();

        $monthData = [];
        for ($date = $month->copy(); $date->month === $month->month; $date->addDay()) {
            $monthData[] = [
                'date' => $date->toDateString(),
                'effective_outcome' => $account->getEffectiveOutcomeAttribute($date),
                'intended_outcome' => $account->getIntendedOutcomeAttribute($date),
                'unallocated_balance' => $account->getUnallocatedBalanceAttribute($date),
                'allocated_balance' => $account->getAllocatedBalanceAttribute($date),
            ];
        }

        $year = is_null($year) ? Carbon::today() : Carbon::createFromFormat('Y-m-d', $year);
        $year->startOfYear();

        $monthLabels = [];
        $yearData = [];
        for ($date = $year->copy(); $date->year === $year->year; $date->addMonth()) {
            $montLabels[] = $date->formatLocalized('%B');

            $yearData[] = [
                'date' => $date->format('Y-m'),
                'effective_outcome' => $account->getEffectiveOutcomeAttribute($date),
                'intended_outcome' => $account->getIntendedOutcomeAttribute($date),
                'unallocated_balance' => $account->getUnallocatedBalanceAttribute($date),
                'allocated_balance' => $account->getAllocatedBalanceAttribute($date),
            ];
        }

        $data = [
            'account' => $account,
            'activeTab' => 'development',
            'month' => $month,
            'prevMonth' => $month->copy()->subMonth(),
            'nextMonth' => $month->copy()->addMonth(),
            'monthData' => json_encode($monthData),
            'monthColors' => json_encode(array_values(Config::get('budget.statusColors'))),
            'year' => $year,
            'prevYear' => $year->copy()->subYear(),
            'nextYear' => $year->copy()->addYear(),
            'montLabels' => json_encode($montLabels),
            'yearData' => json_encode($yearData),
            'yearColors' => json_encode(array_values(Config::get('budget.statusColors'))),
        ];

        return view('account.development', $data);
    }
}
