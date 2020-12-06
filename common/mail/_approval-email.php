<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>::Approval Letter to Company::</title>
        <style>
            * {
                margin: 0px;
                padding: 0px;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 13px;
            }

            td{ vertical-align:top;}

            body {
                margin: 0
            }
            .sheet {
                margin: 0;
                overflow: hidden;
                position: relative;
                box-sizing: border-box;
                page-break-after: always;
            }
            /** Paper sizes **/
            body.A3 .sheet {
                width: 297mm;
                min-height: 419mm
            }
            body.A3.landscape .sheet {
                width: 420mm;
                min-height: 296mm;
            }
            body.A4 .sheet {
                width: 210mm;
                min-height: 296mm
            }
            body.A4.landscape .sheet {
                width: 297mm;
                min-height: 209mm
            }
            body.A5 .sheet {
                width: 148mm;
                min-height: 209mm
            }
            body.A5.landscape .sheet {
                width: 210mm;
                min-height: 147mm
            }
            body.letter .sheet {
                width: 216mm;
                min-height: 279mm
            }
            body.letter.landscape .sheet {
                width: 280mm;
                min-height: 215mm
            }
            body.legal .sheet {
                width: 216mm;
                min-height: 356mm
            }
            body.legal.landscape .sheet {
                width: 357mm;
                min-height: 215mm
            }
            /** Padding area **/
            .sheet.padding-1mm {
                padding: 1mm
            }
            .sheet.padding-2mm {
                padding: 2mm
            }
            .sheet.padding-10mm {
                padding: 10mm
            }
            .sheet.padding-15mm {
                padding: 15mm
            }
            .sheet.padding-20mm {
                padding: 20mm
            }
            .sheet.padding-25mm {
                padding: 25mm
            }



            /** For screen preview **/
            @media screen {
                body {
                    background: #e0e0e0
                }
                .sheet {
                    background: white;
                    box-shadow: 0 .5mm 2mm rgba(0,0,0,.3);
                    margin: 5mm auto;
                }
            }

            /** Fix for Chrome issue #273306 **/
            @media print {

                @page {
                    margin:0;	
                }

                body.A3.landscape {
                    width: 420mm
                }
                body.A3, body.A4.landscape {
                    width: 297mm
                }
                body.A4, body.A5.landscape {
                    width: 210mm
                }
                body.A5 {
                    width: 148mm
                }
                body.letter, body.legal {
                    width: 216mm
                }
                body.letter.landscape {
                    width: 280mm
                }
                body.legal.landscape {
                    width: 357mm
                }
            }
        </style>
    </head>
    <body class="A4">
        <page orientation="portrait" format="A4"  >
            <div class="sheet padding-2mm">
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tr>
                        <td width="100%" align="left" style="text-align:left;"><!--Header section start-->

                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td style="border:1px #ccc solid; padding:2mm; font-size:14px; line-height:18px; text-align:center;"><strong>Investor Education and Protection Fund Authority</strong><br/>
                                        <strong>Government of India</strong><br/>
                                        <span style="font-size:12px;">Ground Floor, Jeevan Vihar Building,<br/>
                                            3, Parliament Street, New Delhi-110001</span></td>
                                </tr>
                            </table>
                            <!--Header section end--> 
                            <!--Spacer table start-->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td style="height:2mm; width:100%;">&nbsp;</td>
                                </tr>
                            </table>
                            <!--Spacer table end-->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td valign="top" width="70%" style="width:70%; line-height:18px;">To,<br/>
                                        <strong>Naresh Motiani</strong>,<br/>
                                        ACC Limited<br/>
                                        EPITOME,Building No.5, Tower A, 20th Floor,<br/>
                                        DLF Cyber City Phase3, Gurgaon 122002
                                    </td>
                                    <td width="70%" style="width:30%; text-align:right;">Dated: 23.04.2019</td>
                                </tr>
                            </table>
                            <!--Spacer table start-->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td style="height:2mm; width:100%;">&nbsp;</td>
                                </tr>
                            </table>
                            <!--Spacer table end-->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td valign="top" width="100%" style="width:100%; font-weight:bold; line-height:18px;">Sub:  Settlement of Claim (IEPF-5) for Akzo Nobel India Limited.</td>
                                </tr>
                            </table>
                            <!--Spacer table start-->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td style="height:4mm; width:100%;">&nbsp;</td>
                                </tr>
                            </table>
                            <!--Spacer table end-->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td valign="top" width="100%" style="width:100%; line-height:18px; font-size:13px; line-height:19px;">Sir/Madam,<br/>
                                        <?= $content; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="bottom" style="height:30mm; text-align:right; padding-right:10mm; vertical-align:bottom">Yours Faithfully,</td>
                                </tr>
                            </table>
                            <!--Spacer table start-->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td style="height:4mm; width:100%;">&nbsp;</td>
                                </tr>
                            </table>
                            <!--Spacer table end-->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td valign="bottom" style="height:30mm; width:50%; text-align:left; padding-left:5mm; vertical-align:bottom"><strong>IEPF Authority</strong>	</td>
                                    <td valign="bottom" style="height:30mm; width:50%; text-align:right; padding-right:10mm; vertical-align:bottom"><strong>Assistant Director</strong></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
    </body>
</html>
