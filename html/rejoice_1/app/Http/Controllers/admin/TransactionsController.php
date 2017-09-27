<?php
namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Datatables;
use App\AdminModel\TransactionsList as TransactionsList;

class TransactionsController extends Controller
{
   /**
     * index
     * 
     * This is used to show the Transactions list
     * 
     * @return Response
     */
    function index() {
        if (request()->ajax()) {
            $transactionsList = TransactionsList::with('user','subscription_type')->orderby('updated_at','desc')->get();
            return Datatables::of($transactionsList)->make(true);
        }
        return view('admin.transaction.index');
    }
}
