<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\Employee; // Make sure this line is included
use Illuminate\Support\Facades\Hash;
class POSController extends Controller
{
    // Redirect to dashboard if user is authenticated, otherwise show login view
    public function index()
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Get the authenticated user's role
            $role = Auth::guard('employee')->user()->role;

            // Redirect based on the user's role
            if ($role === 'Manager') {
                return redirect()->route('dashboard'); // Manager's dashboard
            } elseif ($role === 'Cashier') {
                return redirect()->route('cashierdashboard'); // Cashier's dashboard
            }
        }

        // If not authenticated, return the login view
        return view('index'); // Assuming 'index' is your login view
    }


    // Handle user login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Retrieve the employee record
        $employee = Employee::where('username', $request->username)->first();

        if ($employee) {
            // Check if the employee status is Inactive
            if ($employee->status === 'Inactive') {
                return redirect()->route('login')->with('error', 'Your account is inactive. Please contact support.');
            }

            // Check if the password matches
            $passwordMatches = Hash::check($request->password, $employee->password);

            if ($passwordMatches) {
                Auth::guard('employee')->login($employee);
                $request->session()->regenerate();

                // Store all relevant employee information in the session
                session([
                    'employee_name' => $employee->firstname . ' ' . $employee->lastname,
                    'employee_role' => $employee->role,
                    'employee_email' => $employee->username,
                    'employee_contact' => $employee->contact_number,
                    'employee_age' => $employee->age,
                    'employee_address' => $employee->address,
                    'employee_gender' => $employee->gender,
                    'employee_status' => $employee->status,
                    'employee_avatar' => $employee->avatar,
                ]);

                // Redirect based on role
                if ($employee->role === 'Manager') {
                    return redirect()->route('dashboard'); // Route for manager dashboard
                } elseif ($employee->role === 'Cashier') {
                    return redirect()->route('cashierdashboard'); // Route for cashier dashboard
                }
            }
        }
        return redirect()->route('login')->with('error', 'Invalid username or password. Please try again.');
    }

    public function showInventoryAdjustment()
{
    // Fetch inventory data
    $inventories = Inventory::with('item')->get(); // Assuming you have an Inventory model with item relationship

    // Pass inventories to the view
    return view('inventory.adjustment', compact('inventories'));
}



    // Log out the user and invalidate the session
    public function logout(Request $request): RedirectResponse
    {
        // Perform logout
        Auth::guard('employee')->logout();

        // Clear all session data
        $request->session()->flush(); // This clears all session data

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the session token
        $request->session()->regenerateToken();

        // Redirect to login page with success message
        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }


    // Return the dashboard view for authenticated users
    public function dashboard()
    {
        return view('dashboard');
    }
    public function cashierDashboard()
    {
        return view('cashierdashboard');
    }
    // User management view
    public function user()
    {
        $employees = Employee::paginate(10);
        return view('user.user_management', compact('employees'));
    }

    // Supplier information view
    public function supplier()
    {
        return view('supplier.supplier_information');
    }

    // Order supplies view
    public function orderSupplies()
    {
        return view('supplier.order_supplies');
    }

    // Delivery records view
    public function delivery()
    {
        return view('account.delivery_records');
    }

    // Item management view
    public function itemManagement()
    {
        return view('item.item_management');
    }

    // Inventory management view
    public function inventoryManagement()
    {
        return view('inventory.inventory_management');
    }

    // Inventory adjustment view
    public function inventoryAdjustment()
    {
        return view('inventory.inventory_adjustment');
    }

    // Activity log view
    public function activityLog()
    {
        return view('account.activity_log');
    }

    // Inventory report view
    public function inventoryReport()
    {
        return view('report.inventory_report');
    }

    // Reorder list report view
    public function reorderListReport()
    {
        return view('report.reorder_list_report');
    }

    // Fast moving items report view
    public function fastMovingItemReport()
    {
        return view('report.fast_moving_item_report');
    }

    // Slow moving items report view
    public function slowMovingItemReport()
    {
        return view('report.slow_moving_item_report');
    }

    // Sales report view
    public function salesReport()
    {
        return view('report.sales_report');
    }

    // Stock movement report view
    public function stockMovementReport()
    {
        return view('report.stock_movement_report');
    }

    // Expiration report view
    public function expirationReport()
    {
        return view('report.expiration_report');
    }

    // Sales return report view
    public function salesReturnReport()
    {
        return view('report.sales_return_report');
    }

    // Transaction history report view
    public function transactionHistoryReport()
    {
        return view('report.transaction_history_report');
    }

    public function salereturn()
    {
        return view('cashier.sale-return'); // Ensure this view includes the Livewire component
    }

    public function saletransaction()
    {
        return view('cashier.sale-transaction');
    }

    // User information view (for user accounts)
    public function userInformation()
    {
        return view('user.user_account');
    }
}
