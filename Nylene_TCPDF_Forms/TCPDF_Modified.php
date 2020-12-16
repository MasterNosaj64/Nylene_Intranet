<?php
/*
 * FileName: TCPDF_Modified.php
 * Version Number: 1.0
 * Date Modified: 11/22/2020
 * Author: Jason Waid
 * Purpose:
 * Extends TCPDF, overrides Header() to include Nylene header
 */

// Include the main TCPDF library (search for installation path).
require_once ('../TCPDF/tcpdf.php');

// We creating an instance of the TCPDF class, using TCPDF_NYLENE will use this version (with the modified header) instead of the default
class TCPDF_NYLENE extends TCPDF
{

    // Page header override
    // We override the default header used in TCPDF so it uses the below header
    public function Header()
    {
        // Logo
        // Image Fix
        // Images in header not showing after the 1st page is a known bug, used file_get_contents to convert file to a string
        // Otherwise, the header photo will only appear on the first page
        // https://stackoverflow.com/questions/52662271/tcpdf-header-image-only-displays-on-first-page/56681901#56681901
        $this->Image('@' . file_get_contents('../Graphics/nylene_form_logo.png'), 15, 7.5, 65, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Set font for the header
        $this->SetFont('helvetica', '', 10);

        // Nylene Address
        // writeHTMLCell used x, y coordinates to determine the placment of a cell
        $this->writeHTMLCell(0, 0, 85, 12.5, "200 McNab St,<br>Arnprior, ON<br>K7S 2C7", 0, 2);
        // The below is a blank cell with a border along its southern reagions.
        // This is to provide a border between the Header and the rest of the page.
        $this->writeHTMLCell(0, 0, 15, 25, "", array(
            'B' => array(
                'width' => 1,
                'cap' => 'butt',
                'join' => 'miter',
                'dash' => 0,
                'color' => array(
                    0,
                    0,
                    0
                )
            )
        ), 2);
    }
}
?>