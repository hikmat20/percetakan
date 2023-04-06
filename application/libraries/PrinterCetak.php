<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// IMPORTANT - Replace the following line with your path to the escpos-php autoload script
require_once 'vendor/autoload.php';

use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class PrinterCetak extends Admin_Controller
{

    private $CI;
    private $connector;
    public $printer;

    // TODO: printer settings
    // Make this configurable by printer (32 or 48 probably)
    private $printer_width = 32;

    function __construct()
    {
        $this->CI = &get_instance(); // This allows you to call models or other CI objects with $this->CI->... 
    }

    // function connect($ip_address, $port)
    // {
    //     $this->connector = new NetworkPrintConnector($ip_address, $port);
    //     $this->printer = new Printer($this->connector);
    // }

    function winConnect($printer_name)
    {

        $this->connector    = new WindowsPrintConnector($printer_name);
        $this->printer          = new Printer($this->connector);
    }

    private function check_connection()
    {
        if (!$this->connector or !$this->printer or !is_a($this->printer, 'Mike42\Escpos\Printer')) {
            throw new Exception("Tried to create receipt without being connected to a printer.");
        }
    }

    public function close_after_exception()
    {
        if (isset($this->printer) && is_a($this->printer, 'Mike42\Escpos\Printer')) {
            $this->printer->close();
        }
        $this->connector = null;
        $this->printer = null;
        $this->emc_printer = null;
    }

    // Calls printer->text and adds new line
    private function add_line($text = "", $should_wordwrap = true)
    {
        $text = $should_wordwrap ? wordwrap($text, $this->printer_width) : $text;
        $this->printer->text($text . "\n");
    }

    private function add_line2($text = "", $should_wordwrap = true)
    {
        $text = $should_wordwrap ? wordwrap($text, $this->printer_width) : $text;
        $this->printer->text($text . "\n\n\n\n\n\n\n\n\n\n");
    }

    function buatBaris4Kolom($kolom1, $kolom2, $kolom3, $kolom4)
    {
        // Mengatur lebar setiap kolom (dalam satuan karakter)
        $lebar_kolom_1 = 10;
        $lebar_kolom_2 = 4;
        $lebar_kolom_3 = 14;
        $lebar_kolom_4 = 9;

        // Melakukan wordwrap(), jadi jika karakter teks melebihi lebar kolom, ditambahkan \n 
        $kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);
        $kolom2 = wordwrap($kolom2, $lebar_kolom_2, "\n", true);
        $kolom3 = wordwrap($kolom3, $lebar_kolom_3, "\n", true);
        $kolom4 = wordwrap($kolom4, $lebar_kolom_4, "\n", true);

        // Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
        $kolom1Array = explode("\n", $kolom1);
        $kolom2Array = explode("\n", $kolom2);
        $kolom3Array = explode("\n", $kolom3);
        $kolom4Array = explode("\n", $kolom4);

        // Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
        $jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array), count($kolom3Array), count($kolom4Array));

        // Mendeklarasikan variabel untuk menampung kolom yang sudah di edit
        $hasilBaris = array();

        // Melakukan perulangan setiap baris (yang dibentuk wordwrap), untuk menggabungkan setiap kolom menjadi 1 baris 
        for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {

            // memberikan spasi di setiap cell berdasarkan lebar kolom yang ditentukan, 
            $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");
            $hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebar_kolom_2, " ");

            // memberikan rata kanan pada kolom 3 dan 4 karena akan kita gunakan untuk harga dan total harga
            $hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebar_kolom_2, " ", STR_PAD_LEFT);
            $hasilKolom3 = str_pad((isset($kolom3Array[$i]) ? $kolom3Array[$i] : ""), $lebar_kolom_3, " ", STR_PAD_LEFT);
            $hasilKolom4 = str_pad((isset($kolom4Array[$i]) ? $kolom4Array[$i] : ""), $lebar_kolom_4, " ", STR_PAD_LEFT);

            // Menggabungkan kolom tersebut menjadi 1 baris dan ditampung ke variabel hasil (ada 1 spasi disetiap kolom)
            $hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2 . " " . $hasilKolom3 . " " . $hasilKolom4;
        }

        // Hasil yang berupa array, disatukan kembali menjadi string dan tambahkan \n disetiap barisnya.
        return implode("\n", $hasilBaris) . "\n";
    }

    public function print_test_receipt($text = "")
    {
        $this->check_connection();
        $this->printer->setJustification(Printer::JUSTIFY_CENTER);
        // $this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $this->add_line("TESTING");
        $this->add_line("Receipt Print");
        $this->printer->selectPrintMode();
        $this->add_line(); // blank line
        $this->add_line($text);
        $this->add_line(); // blank line
        $this->add_line(date('Y-m-d H:i:s'));
        $this->add_line2(); // blank line
        // $this->printer->cut();
        $this->printer->close();
    }

    public function print_receipt_bill($id_trans = "")
    {
        $trans      =  $this->db->get_where('view_transactions', ['id' => $id_trans])->row();
        $details    =  $this->db->get_where('view_trans_details', ['trans_id' => $id_trans])->result();
        $payment    =  $this->db->get_where('view_payment_trans', ['trans_id' => $id_trans])->result();


        
        
        // Membuat judul
        $this->winConnect('EPSON TM-U220 Receipt');
        $this->check_connection();
        $this->printer->initialize();
        $this->printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT); // Setting teks menjadi lebih besar
        $this->printer->setJustification(Printer::JUSTIFY_CENTER); // Setting teks menjadi rata tengah
        $this->printer->text("SINAR DIGITAL PRINTING" . "\n");

        $this->printer->initialize();
        $this->printer->selectPrintMode(Printer::MODE_FONT_B); // Setting teks menjadi lebih besar
        $this->printer->setJustification(Printer::JUSTIFY_CENTER); // Setting teks menjadi rata tengah
        $this->printer->text("Jl. Waru No. 7A-B, Rawamangun, Jak-Tim" . "\n\n");

        // Data transaksi
        $this->printer->initialize();
        $this->printer->text("WA    : 0811-8826-272, 0811-9768-684" . "\n");
        $this->printer->text("Email : sinardigitalprinting2@gmail.com"  . "\n");
        $this->printer->setJustification(Printer::JUSTIFY_LEFT); // Setting teks menjadi rata tengah
        $this->printer->selectPrintMode(Printer::MODE_FONT_B); // Setting teks menjadi lebih besar
        $this->printer->text("----------------------------------------\n");
        $this->printer->text("Kasir: " . $trans->created_by_name . "   OP:" . $trans->created_by_name . "\n");
        $this->printer->text("----------------------------------------\n");
        $this->printer->text("No.      : " . $trans->id . "\n");
        $this->printer->text("Tgl/Jam  : " . $trans->date . "\n");
        $this->printer->text("Plg      : " . $trans->customer_name . "\n");
        $this->printer->text("Telepon  : " . $trans->phone . "\n");

        // Membuat tabel
        $this->printer->initialize(); // Reset bentuk/jenis teks
        $this->printer->text("----------------------------------------\n");
        $this->printer->text($this->buatBaris4Kolom("Brg.", "Jml", "Harga", "Subtotal"));
        $this->printer->text("----------------------------------------\n");

        $n = 0;
        foreach ($details as $dtl) {
            $n++;
            $this->printer->text($dtl->products_detail_name . (($dtl->width) ? " - " . $dtl->width . "x" . $dtl->length . "=" . $dtl->subtotal_size : '') . "\n");
            $this->printer->text($this->buatBaris4Kolom("", $dtl->qty, number_format($dtl->price), number_format($dtl->subtotal)));
            ($dtl->discount == 0) ? "" : $this->printer->text($this->buatBaris4Kolom('', '', 'Discount', "-" . number_format($dtl->discount)));
        }
        $this->printer->text("----------------------------------------\n");
        $this->printer->text($this->buatBaris4Kolom('', '', 'Subtotal :', number_format($trans->subtotal)));
        ($trans->discount) ? $this->printer->text($this->buatBaris4Kolom('', '', 'Diskon :', "-" . number_format($trans->discount))) : '';
        $this->printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT);
        $this->printer->setJustification(Printer::JUSTIFY_RIGHT); // Setting teks menjadi rata tengah
        $this->printer->text('Grand Total :' . number_format($trans->grand_total));
        $this->printer->text("\n");
        $this->printer->selectPrintMode(Printer::MODE_FONT_B); // Setting teks menjadi lebih besar
        foreach ($payment as $pay) {
            $this->printer->text($this->buatBaris4Kolom('', '', 'Pembayaran', ''));
            $this->printer->text($this->buatBaris4Kolom("", "", $pay->payment_type_name . " - " . $pay->payment_methode_name . " :", number_format($pay->payment_value)));
            $this->printer->text($this->buatBaris4Kolom('', '', 'Sisa :', number_format($trans->balance)));
            $this->printer->text($this->buatBaris4Kolom('', '', 'Kembalian :', number_format($trans->return)));
        }
        $this->printer->text("----------------------------------------\n");
        $this->printer->text("\n");

        // Pesan penutup
        $this->printer->initialize();
        $this->printer->setJustification(Printer::JUSTIFY_CENTER);
        $this->printer->text("--- Terima Kasih ---" . "\n");

        $this->printer->feed(6); // mencetak 5 baris kosong agar terangkat (pemotong kertas saya memiliki jarak 5 baris dari toner)
        $this->printer->close();
    }
}
