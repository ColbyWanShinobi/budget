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
     * @return Illuminate\Http\Response View to render
     */
    public function getSliders($account_id, $month = null) {
        $account = Auth::user()->accounts()->findOrFail($account_id);

        $month = is_null($month) ? Carbon::today() : Carbon::createFromFormat('Y-m-d', $month);

        $startOfMonth = $month->startOfMonth();
        $endOfMonth = $month->copy()->endOfMonth();

        $prevMonth = $month->copy()->subMonth()->endOfMonth();
        $nextMonth = $month->copy()->addMonth()->startOfMonth();

        $revenue = $account->revenues()->inPeriod($startOfMonth, $endOfMonth)->sum('amount');
        $revenue = $account->revenues()->inPeriod(null, $prevMonth)->sum('amount');
        $income = $account->incomes()->inPeriod(null, $prevMonth)->sum('amount');
        $unallocatedRevenueBeforeMonth = max(0, $revenue - $income);

        $revenue = $account->revenues()->inPeriod($startOfMonth, $endOfMonth)->sum('amount');
        $revenue = $account->revenues()->inPeriod($startOfMonth, $endOfMonth)->sum('amount');
        $income = $account->incomes()->inPeriod($startOfMonth, $endOfMonth)->sum('amount');
        $unallocatedRevenueMonth = max(0, $revenue - $income);

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
            'unallocatedRevenueBeforeMonth' => $unallocatedRevenueBeforeMonth,
            'unallocatedRevenueMonth' => $unallocatedRevenueMonth,
            'incomes' => $incomes,
            'prevIncomes' => $prevIncomes,
            'startOfMonth' => $startOfMonth,
            'endOfMonth' => $endOfMonth,
            'prevMonth' => $prevMonth,
            'nextMonth' => $nextMonth,
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
