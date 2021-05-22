<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssignPackage;
use App\Models\Package;
use App\Models\PackageBoardingPoint;
use App\Models\PackageBooking;
use App\Models\PackagePrice;
use App\Models\PackageRoute;
use App\Services\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageControllers extends Controller
{
    public function index()
    {
        $data = [
            'page_title' => 'Package list',
            'packages' => Package::get()
        ];

        return view('dashboard.package.index')->with(array_merge($this->data, $data));
    }

    public function show($id)
    {
        $data = [
            'page_title' => 'View Package Details',
            'package' => Package::find($id)
        ];

        return view('dashboard.package.show')->with(array_merge($this->data, $data));
    }

    public function create()
    {
        $data = [
            'page_title' => 'Create package',
        ];

        return view('dashboard.package.create')->with(array_merge($this->data, $data));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required'
        ];

        $this->validate($request, $rules);

        try {
            DB::beginTransaction();

            $package = new Package();
            $package->name = $request->get('name');
            $package->short_description = $request->get('short_description');
            $package->description = $request->get('description');
            $package->min_member = $request->get('min_member');

            if ($request->hasFile('thumbnail')) {
                $path = FileUpload::uploadWithResize($request, 'thumbnail', 'package-thubnails', 960, 500);
                $package->thumbnail = $path;
            }

            if ($package->save()) {
                //store package routes
                if ($request->get('routes')) {
                    foreach($request->get('routes') as $key => $package_route) {
                        $p_route = new PackageRoute();
                        $p_route->package_id = $package->id;
                        $p_route->route = $package_route;
                        $p_route->boarding_points = $request->get('boarding_points')[$key];
                        $p_route->save();
                    }
                }

                //store package price
                if ($request->get('package_prices')) {
                    foreach($request->get('package_prices') as $key => $package_price) {
                        $p_price = new PackagePrice();
                        $p_price->package_id = $package->id;
                        $p_price->price = $package_price;
                        $p_price->unit = $request->get('package_units')[$key];
                        $p_price->save();
                    }
                }

                DB::commit();

                return response()->json([
                    'type' => 'success',
                    'title' => 'Saved',
                    'message' => 'New Package Create Successfully',
                ]);
            }

            return response()->json([
                'type' => 'error',
                'title' => 'Failed',
                'message' => 'Failed to create package'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'type' => 'error',
                'title' => 'Something Went Wrong',
                'message' => 'An error occurred while create package. '. $e->getMessage()
            ]);
        }
    }

    public function edit($id)
    {
        $data = [
            'page_title' => 'Package Update',
            'package' => Package::find($id)
        ];

        return view('dashboard.package.edit')->with(array_merge($this->data, $data));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required'
        ];

        $this->validate($request, $rules);

        try {
            DB::beginTransaction();

            $package = Package::find($id);
            $package->name = $request->get('name');
            $package->short_description = $request->get('short_description');
            $package->description = $request->get('description');
            $package->min_member = $request->get('min_member');

            if ($request->hasFile('thumbnail')) {
                $old_image = $package->thumbnail;
                $path = FileUpload::uploadWithResize($request, 'thumbnail', 'package-thubnails', 960, 500);
                $package->thumbnail = $path;
                unlink($old_image);
            }

            if ($package->save()) {
                //store package routes
                if ($request->get('routes')) {
                    $old_package_routes_delete = PackageRoute::where('package_id', $id)->delete();

                    foreach($request->get('routes') as $key => $package_route) {
                        $p_route = new PackageRoute();
                        $p_route->package_id = $package->id;
                        $p_route->route = $package_route;
                        $p_route->boarding_points = $request->get('boarding_points')[$key];
                        $p_route->save();
                    }
                }

                //store package price
                if ($request->get('package_prices')) {
                    $old_package_price_delete = PackagePrice::where('package_id', $id)->delete();
                    foreach($request->get('package_prices') as $key => $package_price) {
                        $p_price = new PackagePrice();
                        $p_price->package_id = $package->id;
                        $p_price->price = $package_price;
                        $p_price->unit = $request->get('package_units')[$key];
                        $p_price->save();
                    }
                }

                DB::commit();

                return response()->json([
                    'type' => 'success',
                    'title' => 'Updated',
                    'message' => 'New Package Updated Successfully',
                ]);
            }

            return response()->json([
                'type' => 'error',
                'title' => 'Failed',
                'message' => 'Failed to update package'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'type' => 'error',
                'title' => 'Something Went Wrong',
                'message' => 'An error occurred while update package. '. $e->getMessage()
            ]);
        }
    }

    public function destroy(Package $package, $id)
    {
        $package = $package->find($id);

        if($package->delete()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Deleted',
                'message' => 'Package Deleted Successfully'
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Failed',
            'message' => 'Failed to Delete'
        ]);
    }

    public function assignPackageStore(Request $request)
    {
        $rules = [
            'from_date' => 'required',
            'to_date' => 'required'
        ];

        $this->validate($request, $rules);

        try {
            $a_package = new AssignPackage();
            $a_package->package_id = $request->get('package');
            $a_package->check_in = database_formatted_date($request->get('from_date'));
            $a_package->check_out = database_formatted_date($request->get('to_date'));

            if ($request->hasFile('thumbnail')) {
                $path = FileUpload::uploadWithResize($request, 'thumbnail', 'package-thubnails', 960, 500);
                $a_package->thumbnail = $path;
            }

            if ($a_package->save()) {
                return response()->json([
                    'type' => 'success',
                    'title' => 'Congratulations!',
                    'message' => 'Package Assigned Successfully.',
                    'redirect' => route('package.show', $request->get('package'))
                ]);
            }

            return response()->json([
                'type' => 'warning',
                'title' => 'Failed to Assign!',
                'message' => 'Failed to assign package'
            ]);

        } catch(\Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => 'Something Went Wrong',
                'message' => 'An error occurred while assign package. '. $e->getMessage()
            ]);
        }

    }

    public function assignPackageDelete($assign_id)
    {
        $package = AssignPackage::find($assign_id);
        $thumbnail = $package->thumbnail;

        if ($package->delete()) {
            if ($thumbnail) {
                unlink($thumbnail);
            }

            return response()->json([
                'type' => 'success',
                'title' => 'Deleted',
                'message' => 'assigned pakcage deleted successfully'
            ]);
        }

        return response()->json([
            'type' => 'warning',
            'title' => 'Failed to Delete!',
            'message' => 'Failed to delete assign package'
        ]);
    }

    public function bookingList()
    {
        $data = [
            'page_title' => 'Package Booking list',
            'bookings' => PackageBooking::orderBy('created_at', 'DESC')->get()
        ];

        return view('dashboard.package.booking')->with(array_merge($this->data, $data));
    }

    public function bookingShow($booking_id)
    {
        $data = [
            'page_title' => 'Package Booking Show',
            'booking' => PackageBooking::find($booking_id)
        ];

        return view('dashboard.package.booking-details')->with(array_merge($this->data, $data));
    }

    public function approvedPackageBooking(Request $request, $booking_id)
    {
        $booking = PackageBooking::find($booking_id);
        $booking->status = 'approved';

        if ($booking->save()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Thank you',
                'message' => 'Booking approved successfullly',
                'redirect' => route('package.booking.show', $booking_id)
            ]);
        }

        return response()->json([
            'type' => 'warning',
            'title' => 'Failed',
            'message' => 'failed to approved package'
        ]);
    }

    public function cancelledPackageBooking(Request $request, $booking_id)
    {
        $booking = PackageBooking::find($booking_id);
        $booking->status = 'cancelled';

        if ($booking->save()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Package Cancelled',
                'message' => 'Package has been cancelled successfully',
                'redirect' => route('package.booking.show', $booking_id)
            ]);
        }

        return response()->json([
            'type' => 'warning',
            'title' => 'Failed',
            'message' => 'failed to cancelled package'
        ]);
    }
}
