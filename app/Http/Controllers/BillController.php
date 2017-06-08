<?php

namespace App\Http\Controllers;

use App\Assignment;
use App\Bill;
use App\Detail;
use App\Transformers\BillTransformer;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bills = Bill::with('details')->with('assignment')->get();

        $bills = fractal($bills, new BillTransformer())
            ->toArray();

        return response()->json($bills);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //obtenemos asignacion
        $assignment = Assignment::findOrFail($request->assignment_id);

        //creamos variable tipo Bill
        $bill = new Bill();
        
        foreach ($request->bill as $k => $v) {
            if ($k == 'bill_number') {
                $bill->bill_number = $v;
                $bill->assignment()->associate($assignment);
                $bill->save();
                break;
            }
        }

        $details = [];
        foreach ($request->bill as $k => $v) {
            if ($k == 'details') {
                $details = (array)$v;
                break;
            }
        }

        foreach ($details as $item) {
            $detail = new Detail();

            foreach ($item as $key => $value) {
                if ($key == 'description') {
                    $detail->description = $value;
                }
                if ($key == 'quantity') {
                    $detail->quantity = $value;
                }
                if ($key == 'unitary_cost') {
                    $detail->unitary_price = $value;
                }
            }
            $detail->total_item = $detail->quantity * $detail->unitary_price;
            $detail->bill()->associate($bill);
            $detail->save();
        }

        $total = 0;
        foreach ($bill->details as $detail) {
            $total += $detail->total_item;
        }

        $bill->total = $total;

        $bill->file_path = 'invoices/'.$bill->bill_number.'.pdf';

        $pdf = PDF::loadView('invoices.pdf', compact('assignment', 'total'))->setPaper('a4', 'portrait');
        $pdf->save($bill->file_path);
        
        $bill->update();
        
        return response()->json(['code' => 200, 'success' => true]);
    }

    /**
     * Display the cified resource.
     *
     * @param Bill $bill
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(Bill $bill)
    {
//        $bill = Bill::findOrFail($id)->with('details')->with('assignment')->get();

        $bill = fractal($bill, new BillTransformer())
            ->toArray();

        return response()->json($bill);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bill $bill)
    {
//        return response()->json(true);
//        return response()->json([$bill->id]);
//        return response()->json(['bill'=> $bill, 'request'=>$request]);
//        //obtenemos asignacion
//        $assignment = Assignment::findOrFail($request->assignment_id);
//
//        //creamos variable tipo Bill
//        $bill = new Bill();

        $assignment = $bill->assignment;

        foreach ($request->bill as $k => $v) {
            if ($k == 'bill_number') {
                $bill->bill_number = $v;
                $bill->update();
                break;
            }
        }

        $bill->details()->delete();

        $details = [];
        foreach ($request->bill as $k => $v) {
            if ($k == 'details') {
                $details = (array)$v;
                break;
            }
        }

        foreach ($details as $item) {
            $detail = new Detail();

            foreach ($item as $key => $value) {
                if ($key == 'description') {
                    $detail->description = $value;
                }
                if ($key == 'quantity') {
                    $detail->quantity = $value;
                }
                if ($key == 'unitary_cost') {
                    $detail->unitary_price = $value;
                }
            }
            $detail->total_item = $detail->quantity * $detail->unitary_price;
            $detail->bill()->associate($bill);
            $detail->save();
        }

        $total = 0;
        foreach ($bill->details as $detail) {
            $total += $detail->total_item;
        }

        $bill->total = $total;

        $bill->file_path = 'invoices/'.$bill->bill_number.'.pdf';

        $pdf = PDF::loadView('invoices.pdf', compact('assignment', 'total'))->setPaper('a4', 'portrait');
        $pdf->save($bill->file_path);

        $bill->update();

        return response()->json(['code' => 200, 'success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function showPdf(Request $request, Bill $bill)
    {
        return $request->user()->id;
    }
}
