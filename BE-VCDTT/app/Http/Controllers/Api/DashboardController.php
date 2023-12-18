<?php

namespace App\Http\Controllers\Api;

use stdClass;
use Carbon\Carbon;
use App\Models\Blog;
use App\Models\Tour;
use App\Models\User;
use App\Models\Rating;
use Illuminate\Http\Request;
use Spatie\Analytics\Period;
use App\Models\PurchaseHistory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PHPUnit\Framework\Constraint\Count;
use Spatie\Analytics\Facades\Analytics;
use App\Http\Resources\DashboardResource;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }
    public function totalEarnDashboard(Request $request)
    {
        $data = [];
        //
        $data['UVCount'] = Count(PurchaseHistory::where('purchase_status', 2)->get());

        //
        $purchaseHistory = PurchaseHistory::where('payment_status', 2)->where('purchase_status', 3)->whereIn('tour_status', [2, 3])->get();
        $total = [];
        foreach ($purchaseHistory as $purchaseHistory) {
            $final['price'] = $purchaseHistory->tour_child_price * $purchaseHistory->child_count + $purchaseHistory->tour_adult_price * $purchaseHistory->adult_count;
            $final['price'] = $final['price'] - ($purchaseHistory->coupon_percentage == null ? ($purchaseHistory->coupon_fixed ?? 0) : 0) - ($final['price'] / 100 * ($purchaseHistory->coupon_percentage ?? 0 + $purchaseHistory->tour_sale_percentage ?? 0));
            $final['time'] = date("d-m-Y", strtotime($purchaseHistory->created_at));
            array_push($total, $final);
        }

        // $data['total'] = $total['price'];
        // dd($total['price']);
        // dd($total);

        $total_total = 0;
        foreach ($total as $d) {
            $total_total += $d['price'];
        }
        $data['total_total'] = $total_total;
        //
        $data['today'] = 0;
        $data['week'] = 0;
        $data['month'] = 0;
        $data['year'] = 0;
        foreach ($total as $d) {
            if ($d['time'] == date("d-m-Y")) {
                $data['today'] += $d['price'];
            }
            if (date("W-Y", strtotime($d['time'])) == date("W-Y")) {
                $data['week'] += $d['price'];
            }
            if (date("m-Y", strtotime($d['time'])) == date("m-Y")) {
                $data['month'] += $d['price'];
            }
            if (date("Y", strtotime($d['time'])) == date("Y")) {
                $data['year'] += $d['price'];
            }
        }

        //
        $paidPurchase = PurchaseHistory::where('payment_status', 2)->where('purchase_status', 3)->whereIn('tour_status', [2, 3])->get();

        $data['PPCToday'] = 0;
        $data['PPCWeek'] = 0;
        $data['PPCMonth'] = 0;
        $data['PPCYear'] = 0;
        foreach ($paidPurchase as $PP) {
            if (date("d-m-Y", strtotime($PP->created_at)) == date("d-m-Y")) {
                $data['PPCToday']++;
            }
            if (date("W-Y", strtotime($PP->created_at)) == date("W-Y")) {
                $data['PPCWeek']++;
            }
            if (date("m-Y", strtotime($PP->created_at)) == date("m-Y")) {
                $data['PPCMonth']++;
            }
            if (date("Y", strtotime($PP->created_at)) == date("Y")) {
                $data['PPCYear']++;
            }
        }
        //chartpie view
        $sort = $request->sort ?? 'view_count';
        $direction = $request->direction ?? 'desc';
        $tourViewCounts = Tour::select('id', 'name', 'view_count')->orderBy($sort, $direction)->limit(10)->get();
        $data['tourVC'] = $tourViewCounts;

        //chartpie rating
        $sort = $request->sort ?? 'view_count';
        $direction = $request->direction ?? 'desc';
        $tourRatings = Tour::select('id', 'name')->get();
        foreach ($tourRatings as $tour) {
            $listRatings = Rating::where('tour_id', $tour->id)->orderBy('id', 'desc')->get();
            $star = 0;
            $t = 0;
            foreach ($listRatings as $c) {
                $star += $c->star;
                $t++;
            }
            $tour->star = $star / ($t == 0 ? 1 : $t);
            $tour->starCount = $t;
        }
        $tourRatings = collect($tourRatings);
        $tourRatings = $tourRatings->sortByDesc(function ($item) {
            return $item['star'];
        });
        $tourRatings = $tourRatings->filter(function ($a) {
            return $a->star > 0;
        })->slice(0, 10);
        $data['tourR'] = $tourRatings;

        //chart
        $months = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        foreach ($total as $d) {
            for ($i = 0; $i < 12; $i++) {
                $i < 9 ? $mrp = "0" . ($i + 1) : $mrp = $i + 1;
                if (date("m-Y", strtotime($d['time'])) == $mrp . "-" . date("Y")) {
                    $months[$i] += number_format($d['price'] / 1000000, 2);
                }
            }
        }
        $data['chart'] = $months;
        // Tổng số user
        $data['users'] = User::whereNull('deleted_at')->count();
        // Tổng số bài viết
        $data['blogs'] = Blog::whereNull('deleted_at')->count();

        //Số lượt xem page
        $date = '2016-08-13';
        $startDate = Carbon::createFromFormat('Y-m-d', $date);
        $today = Carbon::now();

        $analytics = Analytics::fetchTotalVisitorsAndPageViews(Period::create($startDate, $today));
        $yesterdayData = Analytics::fetchTotalVisitorsAndPageViews(Period::create($startDate, $today->subDay()));
        $twoDaysBeforeData = Analytics::fetchTotalVisitorsAndPageViews(Period::create($startDate, $today->subDays(2)));
        $threeDaysBeforeData = Analytics::fetchTotalVisitorsAndPageViews(Period::create($startDate,  $today->subDays(3)));
        $fourDaysBeforeData = Analytics::fetchTotalVisitorsAndPageViews(Period::create($startDate,  $today->subDays(4)));
        $fiveDaysBeforeData = Analytics::fetchTotalVisitorsAndPageViews(Period::create($startDate,  $today->subDays(5)));
        $sixDaysBeforeData = Analytics::fetchTotalVisitorsAndPageViews(Period::create($startDate,  $today->subDays(6)));

        $data['totalViews'] = new stdClass();
        $data['totalViews']->sixDaysBefore = 0;
        $data['totalViews']->fiveDaysBefore = 0;
        $data['totalViews']->fourDaysBefore = 0;
        $data['totalViews']->threeDaysBefore = 0;
        $data['totalViews']->twoDaysBefore = 0;
        $data['totalViews']->yesterday = 0;
        $data['totalViews']->totalViews = 0;

        foreach ($analytics as $analytic) {
            $data['totalViews']->totalViews += $analytic['screenPageViews'];
        }
        foreach ($yesterdayData as $yesterday) {
            $data['totalViews']->yesterday += $yesterday['screenPageViews'];
        }
        foreach ($twoDaysBeforeData as $twoDaysBefore) {
            $data['totalViews']->twoDaysBefore += $twoDaysBefore['screenPageViews'];
        }
        foreach ($threeDaysBeforeData as $threeDaysBefore) {
            $data['totalViews']->threeDaysBefore += $threeDaysBefore['screenPageViews'];
        }
        foreach ($fourDaysBeforeData as $fourDaysBefore) {
            $data['totalViews']->fourDaysBefore += $fourDaysBefore['screenPageViews'];
        }
        foreach ($fiveDaysBeforeData as $fiveDaysBefore) {
            $data['totalViews']->fiveDaysBefore += $fiveDaysBefore['screenPageViews'];
        }
        foreach ($sixDaysBeforeData as $sixDaysBefore) {
            $data['totalViews']->sixDaysBefore += $sixDaysBefore['screenPageViews'];
        }

        //Top 10 tour có doanh thu cao nhất
        $data['chartTop5ToursBySale'] = Tour::join('purchase_histories', 'tours.name', '=', 'purchase_histories.tour_name')
            ->select(
                'tours.name',
                DB::raw('SUM((purchase_histories.child_count * tours.child_price) + (purchase_histories.adult_count * tours.adult_price)) as total_tour_price')
            )
            ->where('purchase_histories.payment_status', 2)
            ->where('purchase_histories.purchase_status', 3)
            ->groupBy('tours.name')
            ->orderBy('total_tour_price', 'desc')
            ->get(10);

        $data = json_decode(json_encode($data));
        return view('admin.dashboards.tour', compact('data'));
    }

    public function userDashboard(Request $request)
    {
        //
        $data['userCount'] = Count(User::where('is_admin', '!=', 1)->orWhereNull('is_admin')->get());
        //
        $data['userBannedCount'] = Count(User::where('is_admin', '!=', 1)->orWhereNull('is_admin')->where('status', 3)->get());
        // chua dang ky
        $data['notRegCount'] = PurchaseHistory::select('email')
            ->whereNotIn('email', User::select('email')->where('is_admin', '!=', 1)->orWhereNull('is_admin'))
            ->count();

        $counts = User::where('is_admin', '!=', 1)->orWhereNull('is_admin')->whereIn('gender', [1, 2, 3])->selectRaw('gender, COUNT(*) as count')->groupBy('gender')->pluck('count', 'gender');

        $data['genderDP'] = [
            $counts->get(1, 0),
            $counts->get(2, 0),
            $counts->get(3, 0),
        ];
        $now = date('Y-m-d');
        $ageGroups = [
            '18-24' => 0,
            '25-34' => 0,
            '35-44' => 0,
            '45+' => 0,
        ];

        foreach ($ageGroups as $range => &$count) {
            if ($range === '18-24') {
                $startYear = date('Y-m-d', strtotime('-24 years', strtotime($now)));
                $endYear = date('Y-m-d', strtotime('-18 years', strtotime($now)));
            } elseif ($range === '25-34') {
                $startYear = date('Y-m-d', strtotime('-34 years', strtotime($now)));
                $endYear = date('Y-m-d', strtotime('-25 years', strtotime($now)));
            } elseif ($range === '35-44') {
                $startYear = date('Y-m-d', strtotime('-44 years', strtotime($now)));
                $endYear = date('Y-m-d', strtotime('-35 years', strtotime($now)));
            } elseif ($range === '45+') {
                $startYear = date('Y-m-d', strtotime('-999 years', strtotime($now)));
                $endYear = date('Y-m-d', strtotime('-45 years', strtotime($now)));
            }

            $count = User::where('is_admin', '!=', 1)->orWhereNull('is_admin')->whereBetween('date_of_birth', [$startYear, $endYear])->count();
        }

        unset($count); // Remove reference to avoid potential issues

        $data['ageDP'] = $ageGroups;
        $data = json_decode(json_encode($data));
        return view('admin.dashboards.user', compact('data'));
    }

    public function get_users_by_status(Request $request)
    {
        if ($request->status == 1) {
            $data = User::where('status', 1)->whereNull('deleted_at')->count();
            return $data;
        } else {
            $data = User::where('status', '!=', 1)->whereNull('deleted_at')->count();
            return $data;
        }
    }
    public function get_blogs_by_status(Request $request)
    {
        if ($request->status == 1) {
            $data = Blog::where('status', 1)->whereNull('deleted_at')->count();
            return $data;
        } else {
            $data = Blog::where('status', '!=', 1)->whereNull('deleted_at')->count();
            return $data;
        }
    }
}
