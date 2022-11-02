<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Display calculations
        $prices = Price::select('gross_sum', 'vat_rate')->get();

        return view('price.index', ['prices' => $prices]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request form data
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Store given value and vat rate in database
        $price = new Price();
        $price->gross_sum =$request->input('gross_sum');
        //Convert percentage user input to decimal then determine if postive or negative
        //Add or remote VAT. Eg 20 * -1 = -20. 20 * 1 = 20.
        $price->vat_rate = ($request->input('vat_rate') / 100) * $request->input('multiplier');
        $price->save();

        return redirect()->back();
    }

    /**
     * Export price calculations as .csv file
     */
    public function exportAsCSV()
    {
        $fileName = 'calculations.csv';

        $prices = Price::all();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Amount', 'VAT Rate', 'Total'];

        $callback = function() use ($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($prices as $price) {
                $row['Amount'] = $price->gross_sum;
                $row['VAT Rate'] = $price->vat_rate_formatted;
                $row['Total'] = $price->final_price;

                fputcsv($file, [$row['Amount'], $row['VAT Rate'], $row['Total']]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Delete all values from prices database
     */
    public function clear()
    {
        //Do check so that all() isnt used as this prevents deleting everything
        Price::whereNotNull('price_id')->delete();

        return redirect()->back();
    }
}
