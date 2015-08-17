<?php namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Income;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AllocationController extends Controller
{
    /**
     * Render income allocation related to one account (second tab)
     * @param  string $account_id Account ID
     * @return Illuminate/Http/Response View to render
     */
    public function getSliders($account_id, $month = null) {
        $account = Auth::user()->accounts()->findOrFail($account_id);

        $month = is_null($month) ? Carbon::today() : Carbon::createFromFormat('Y-m-d', $month);

        $startOfMonth = $month->startOfMonth();
        $endOfMonth = $month->copy()->endOfMonth();

        $revenue = $account->getRevenueAttribute($startOfMonth, $endOfMonth);
        $incomes = $account->incomes()
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->lists('amount', 'envelope_id')
            ->toArray();

        $prevIncomes = $account->incomes()
            ->whereBetween('date', [
                $month->copy()->subMonth()->startOfMonth(),
                $month->copy()->subMonth()->endOfMonth(),
            ])
            ->lists('amount', 'envelope_id')
            ->toArray();

        $data = [
            'account' => $account,
            'revenue' => $revenue,
            'incomes' => $incomes,
            'prevIncomes' => $prevIncomes,
            'maxIncome' => count($incomes) ? max(max($incomes), $revenue) : $revenue,
            'startOfMonth' => $startOfMonth,
            'endOfMonth' => $endOfMonth,
            'prevMonth' => $month->copy()->subMonth(),
            'nextMonth' => $month->copy()->addMonth(),
        ];

        return view('account.allocation.sliders', $data);
    }

    public function postSliders(Request $request, $account_id, $month = null) {
        $account = Auth::user()->accounts()->findOrFail($account_id);

        $month = is_null($month) ? Carbon::today() : Carbon::createFromFormat('Y-m-d', $month);

        $startOfMonth = $month->startOfMonth();
        $endOfMonth = $month->copy()->endOfMonth();

        $incomes = $account->incomes()
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->delete();

        foreach ($account->envelopes as $envelope) {
            $amount = floatval($request->input('income-'.$envelope->id, 0));

            if ($amount > 0) {
                $envelope->incomes()->save(new Income([
                    'amount' => $amount,
                    'date' => $startOfMonth,
                ]));
            }
        }

        return redirect()->action(
            'Account\AllocationController@getSliders',
            [$account_id, $month->toDateString()]
        );
    }
}
