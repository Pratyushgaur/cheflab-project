<?php

namespace App\Exports;

// use Excel;
use App\Models\OrderCommision;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Facades\Excel;
use DB;
class OrderExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $id;

    function __construct($request) {
        
            $this->request = $request;
            // echo '<pre>'; print_r($this->request->all());die;
    }

    public function collection()
    {
        $date = explode('/',$this->request->start_date);
        $start_date = date('Y-m-d',strtotime($date[0]));
        $end_date = date('Y-m-d',strtotime($date[1]));
        $id  = $this->request->id;     
       
        $report = OrderCommision::where('order_commisions.vendor_id',$id)->join('orders','order_commisions.order_id','=','orders.id')->select('order_commisions.*','orders.payment_type','orders.payment_status')->orderBy('order_commisions.id', 'DESC');       
                        
            if(!empty($start_date) && !empty($end_date)) {
                $report = $report->whereBetween('order_commisions.order_date', [$start_date, $end_date]);
            }
                       
            $result=$report->get();                       
                       
        return $result;

    }
    public function headings(): array
    {
        return [
            'Order Id',
            'Order Date',
            'Payment Method',
            'Gross Revenue',
            'Net Receivable',
            'Payment Status',
            'Status',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 35,
            'B' => 35,            
            'C' => 35 ,        
            'D' => 35,         
            'E' => 35 ,        
            'F' => 35 ,        
            'G' => 35 ,        
        ];
    }


    public function map($order): array
    {   
        if($order->is_approve == 1){
            $status = 'Approve';
        }elseif($order->is_cancel == 1){
            $status = 'Cancel';
        }else{
            $status = 'Pending';
        }
       
        return [
            $order->order_id,
            $order->order_date,
            $order->payment_type,
            $order->gross_revenue,
            $order->net_receivables,
            $order->payment_status,
            $status
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
   
                $event->sheet->getDelegate()->getStyle('A1:O1')
                                ->getFont()
                                ->setBold(true);
                                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(11);
   
            },
        ];
    }
}
