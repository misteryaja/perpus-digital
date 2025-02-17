<?php

namespace App\Libraries;

use TCPDF;

/**
 * Description of Pdf Library
 *
 * @author https://roytuts.com
 */
// class PdfLibrary extends TCPDF
// {

//     function __construct()
//     {
//         parent::__construct();
//     }

//     //Page header
//     public function Header()
//     {
//         // Set font
//         $this->SetFont('helvetica', 'B', 20);
//         // Title
//         $this->SetX(55);
//         $this->Cell(0, 2, 'Prints Summary Perpus Digi', 0, 1, '', 0, '', 0);

//         $style = array('width' => 0.50, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
//         $this->Line(15, 18, 195, 18, $style);
//     }

//     // Page footer
//     public function Footer()
//     {
//         // Position at 15 mm from bottom
//         $this->SetY(-15);
//         // Set font
//         $this->SetFont('helvetica', 'I', 8);
//         // Page number
//         $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
//     }
// }

class PdfLibrary extends TCPDF
{
    public function __construct()
    {
        parent::__construct();
    }

    // Page header
    public function Header()
    {
        // Set font for the header
        $this->SetFont('helvetica', 'I', 20);
        // Add title
        $this->SetY(10);
        $this->Cell(0, 10, 'Print Summary Perpus Digi', 0, 1, 'C', 0, '', 0);

        // Add a horizontal line below the title
        $style = array('width' => 0.50, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
        $this->Line(15, 25, 195, 25, $style);
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font for the footer
        $this->SetFont('helvetica', 'I', 8);
        // Add page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    // Custom function to add a table with styled headers
    public function CreateStyledTable($header, $data)
    {
        // Set header styles
        $this->SetFont('helvetica', 'B', 10); // Bold font for headers
        $this->SetFillColor(230, 230, 230); // Light grey background
        $this->SetTextColor(0); // Black text color
        $this->SetDrawColor(0, 0, 0); // Black border color
        $this->SetLineWidth(0.3);

        // Set column widths (adjust according to your needs)
        $w = array(40, 80, 30, 40); // Example: 4 columns

        // Print header
        for ($i = 0; $i < count($header); ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();

        // Set body styles
        $this->SetFont('helvetica', '', 9); // Regular font for body
        $this->SetFillColor(245, 245, 245); // Alternating row background color
        $fill = 0;

        // Print data
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row['id'], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row['title'], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $row['date'], 'LR', 0, 'C', $fill);
            $this->Cell($w[3], 6, $row['amount'], 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill = !$fill; // Toggle fill color for alternating rows
        }

        // Close the table with a bottom border
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}
