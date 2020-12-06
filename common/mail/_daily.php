<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>::REC::</title>
        <style type="text/css">
            * {
                margin: 0px;
                padding: 0px;
            }
            /* Based on The MailChimp Reset INLINE: Yes. */  
            /* Client-specific Styles */
            #outlook a {
                padding: 0;
            } /* Force Outlook to provide a "view in browser" menu link. */
            body {
                width: 100% !important;
                background-color: #ffffff;
                -webkit-text-size-adjust: 100%;
                -ms-text-size-adjust: 100%;
                margin: 0;
                padding: 0;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;
            }
            /* Prevent Webkit and Windows Mobile platforms from changing default font sizes.*/ 
            .ExternalClass {
                width: 100%;
            } /* Force Hotmail to display emails at full width */
            .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
                line-height: 100%;
            }
            /* Forces Hotmail to display normal line spacing.  More on that: http://www.emailonacid.com/forum/viewthread/43/ */ 
            #backgroundTable {
                margin: 0;
                padding: 0;
                width: 640px;
                background: #70cce2 !important;
                line-height: 100% !important;
            }
            /* End reset */

            /* Some sensible defaults for http://demodevelopment.com/ilpm/mailer-img/new-mailer/
            Bring inline: Yes. */
            img {
                outline: none;
                text-decoration: none;
                -ms-interpolation-mode: bicubic;
            }
            a img {
                border: none;
            }
            .image_fix {
                display: block;
            }
            /* Yahoo paragraph fix
                            Bring inline: Yes. */
            p {
                margin: 0px;
                padding: 0px;
            }
            /* Hotmail header color reset
                            Bring inline: Yes. */
            h1, h2, h3, h4, h5, h6 {
                color: black !important;
            }
            h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {
                color: blue !important;
            }
            h1 a:active, h2 a:active, h3 a:active, h4 a:active, h5 a:active, h6 a:active {
                color: red !important; /* Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. */
            }
            h1 a:visited, h2 a:visited, h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
                color: purple !important; /* Preferably not the same color as the normal header link color. There is limited support for psuedo classes in email clients, this was added just for good measure. */
            }
            /* Outlook 07, 10 Padding issue fix
                            Bring inline: No.*/
            table td {
                border-collapse: collapse;
            }
            /* Remove spacing around Outlook 07, 10 tables
                            Bring inline: Yes */
            table {
                border-collapse: collapse;
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt;
            }
            table {
                border-spacing: 0 !important;
            }
            /* Styling your links has become much simpler with the new Yahoo.  In fact, it falls in line with the main credo of styling in email and make sure to bring your styles inline.  Your link colors will be uniform across clients when brought inline.
                            Bring inline: Yes. */
            a {
                color: orange;
                text-decoration: none !important;
            }
            table td {
                border: 0;
            }

            /***************************************************
            ****************************************************
            MOBILE TARGETING
            ****************************************************
            ***************************************************/
            @media only screen and (max-device-width: 480px) {
                /* Part one of controlling phone number linking for mobile. */
                a[href^="tel"], a[href^="sms"] {
                    text-decoration: none;
                    color: blue; /* or whatever your want */
                    pointer-events: none;
                    cursor: default;
                }
                .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                    text-decoration: default;
                    color: orange !important;
                    pointer-events: auto;
                    cursor: default;
                }
            }

            /* More Specific Targeting */

            @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
                /* You guessed it, ipad (tablets, smaller screens, etc) */
                /* repeating for the ipad */
                a[href^="tel"], a[href^="sms"] {
                    text-decoration: none;
                    color: blue; /* or whatever your want */
                    pointer-events: none;
                    cursor: default;
                }
                .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                    text-decoration: default;
                    color: orange !important;
                    pointer-events: auto;
                    cursor: default;
                }
            }
            @media only screen and (-webkit-min-device-pixel-ratio: 2) {
                /* Put your iPhone 4g styles in here */ 
            }

            /* Android targeting */
            @media only screen and (-webkit-device-pixel-ratio:.75) {
                /* Put CSS for low density (ldpi) Android layouts in here */
            }
            @media only screen and (-webkit-device-pixel-ratio:1) {
                /* Put CSS for medium density (mdpi) Android layouts in here */
            }
            @media only screen and (-webkit-device-pixel-ratio:1.5) {
                /* Put CSS for high density (hdpi) Android layouts in here */
            }
            /* end Android targeting */
        </style>

        <!-- Targeting Windows Mobile -->
        <!--[if IEMobile 7]>
                <style type="text/css">
                
                </style>
                <![endif]-->

        <!-- ***********************************************
                ****************************************************
                END MOBILE TARGETING
                ****************************************************
                ************************************************ -->

        <!--[if gte mso 9]>
                        <style>
                        /* Target Outlook 2007 and 2010 */
                        </style>
                <![endif]-->
    </head>
    <body>
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
                <td height="20"><img src="http://demodevelopment.com/security-mailer/spacer-img.png" alt="" width="1" height="20"  border="0" style="display: block;" /></td>
            </tr>
            <tr>
                <td    valign="middle" align="center">

                    <table cellpadding="0" cellspacing="0" border="0" width="842">
                        <tr>
                            <td style="border:1px #000000 solid;">


                                <table cellpadding="0" cellspacing="0" border="0" width="840">
                                    <tr>
                                        <td colspan="3" height="20"><img src="http://demodevelopment.com/security-mailer/spacer-img.png" alt="" width="1" height="20"  border="0" style="display: block;" /></td>
                                    </tr>
                                    <tr>
                                        <td width="20" valign="middle"><img src="http://demodevelopment.com/security-mailer/spacer-img.png" alt="" width="20" height="10"  border="0" style="display: block;" /></td>
                                        <td width="600" valign="top">

                                            <table cellpadding="0" cellspacing="0" border="0" width="800">
                                                <tr>
                                                    <td style="border:1px #000000 solid;">
                                                        <table cellpadding="0" cellspacing="0" border="0"  style="width:100%">
                                                            <tr>
                                                                <td colspan="4" height="5"><img src="http://demodevelopment.com/security-mailer/spacer-img.png" alt="" width="5" height="5"  border="0" style="display: block;" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="2%"><img src="http://demodevelopment.com/security-mailer/spacer-img.png" alt="" width="5" height="1"  border="0" style="display: block;" /></td>


                                                                <td width="2%"><img src="http://demodevelopment.com/security-mailer/spacer-img.png" alt="" width="5" height="1"  border="0" style="display: block;" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td  colspan="4"  height="5"><img src="http://demodevelopment.com/security-mailer/spacer-img.png" alt="" width="5" height="5"  border="0" style="display: block;" /></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>


                                            <table cellpadding="0" cellspacing="0"  width="100%">
                                                <tr>
                                                    <td height="15"><img src="http://demodevelopment.com/security-mailer/spacer-img.png" alt="" width="5" height="15"  border="0" style="display: block;" /></td>
                                                </tr>
                                            </table>
                                            <table cellpadding="0" cellspacing="0"  width="100%">
                                                <tr>
                                                    <td style="font-size:13px; line-height:19px; font-family:Arial, Helvetica, sans-serif;" valign="top"><strong>To<br/>
                                                            The Nodal Officer (Saubhagya)<br/>
                                                            <?= isset($params['discomName']) ? $params['discomName'] : 'N/A'; ?> <br/>
                                                        </strong>
                                                        <?= isset($params['officeAddress']) ? $params['officeAddress'] : 'N/A'; ?> </td>
                                                </tr>
                                                <tr>
                                                    <td height="15"><img src="http://demodevelopment.com/security-mailer/spacer-img.png" alt="" width="5" height="15"  border="0" style="display: block;" /></td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" style="font-size:13px; line-height:19px;  font-family:Arial, Helvetica, sans-serif;"><strong>Sir/Madam,</strong><br/>
                                                        It is to bring to your kind notice that the consumers under your areas of jurisdiction (List of consumers along with their grievances are enclosed herewith as an Annexure-I) have contacted REC Control Centre requesting for electricity connection for their households and their grievances have been registered in REC Control Centre Web Portal.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="15"><img src="http://demodevelopment.com/security-mailer/spacer-img.png" alt="" width="5" height="15"  border="0" style="display: block;" /></td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" style="font-size:13px; line-height:19px; font-family:Arial, Helvetica, sans-serif;"> 

                                                        It is requested to take immediate action to arrange to provide electricity connections under Saubhagya Scheme to the aforesaid premises at the earliest and confirm the same to this office through letter/mail/phone on Email: <a href="mailto:reccontrolroom@gmail.com" style="color:#06F; text-decoration:underline !important;">reccontrolroom@gmail.com </a>and 011-43091766 (CC) under intimation to the undersigned so as to resolve/settle their grievances through REC Control Centre.
                                                </tr>
                                                <tr>
                                                    <td height="40"><img src="http://demodevelopment.com/security-mailer/spacer-img.png" alt="" width="5" height="40"  border="0" style="display: block;" /></td>
                                                </tr>
                                                <tr>
                                                    <td align="right" valign="top" style="font-size:12px; line-height:18px; font-family:Arial, Helvetica, sans-serif;"> <strong style="color:#000; font-size:12px; line-height:18px; font-family:Arial, Helvetica, sans-serif;">Yours faithfully,</strong><br/> 
                                                        <span style="color:#333; font-size:12px; line-height:18px; font-family:Arial, Helvetica, sans-serif;"> (Ashmi Shukla)<br/>
                                                            Project Engineer (CC)<br/>
                                                            REC Control Centre<br/>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="40"><img src="http://demodevelopment.com/security-mailer/spacer-img.png" alt="" width="5" height="40"  border="0" style="display: block;" /></td>
                                                </tr>
                                                <tr>
                                                    <td valign="top">
                                                        <table cellpadding="0" cellspacing="0"  width="800" style="font-size:12px; line-height:18px;">

                                                            <tr>
                                                                <td style="font-size:12px; line-height:18px; font-family:Arial, Helvetica, sans-serif;" colspan="2"><strong>Copy to:</strong></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-size:12px; line-height:18px; font-family:Arial, Helvetica, sans-serif;" valign="top" width="15"><strong>1.</strong></td>
                                                                <td style="font-size:12px; line-height:18px; font-family:Arial, Helvetica, sans-serif;" valign="top" width="585">The Sr. CPM/CPM, REC Regional Office, REC Ltd, ________________ for follow up please.</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-size:12px; line-height:18px; font-family:Arial, Helvetica, sans-serif;" valign="top" width="15"><strong>2.</strong></td>
                                                                <td style="font-size:12px; line-height:18px; font-family:Arial, Helvetica, sans-serif;" valign="top" width="585">The Nodal Officer, REC Regional Office, REC Ltd________________ for follow up please.</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="20"><img src="http://demodevelopment.com/security-mailer/spacer-img.png" alt="" width="5" height="20"  border="0" style="display: block;" /></td>
                                                </tr>
                                                <tr>
                                                    <td valign="top">
                                                        <table cellpadding="2" cellspacing="2" border="1"  width="800" style="font-size:12px; line-height:18px;">
                                                            <thead>
                                                                <tr>
                                                                    <th align="left" valign="top" width="50" style="padding:2px">Sl.</th>
                                                                    <th align="left" valign="top" width="200" style="padding:2px">Grievance <br/>Ref. No.</th>
                                                                    <th align="left" valign="top"  width="150" style="padding:2px">Name of consumer</th>
                                                                    <th align="left" valign="top" width="200" style="padding:2px">Consumer <br/>Details</th>
                                                                    <th align="left" valign="top" width="100" style="padding:2px">Nature of <br/>Grievance</th>
                                                                    <th align="left" valign="top" width="50" style="padding:2px">Remarks/Status</th>
                                                                </tr>
                                                            </thead>
                                                            <?php if (isset($params['grievances']) && !empty($params['grievances'])): ?>
                                                                <?php
                                                                $i = 1;
                                                                foreach ($params['grievances'] as $grievance):
                                                                    ?>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td align="left" valign="top" width="50" style="padding:2px; border-bottom:1px #ccc solid;"><?= $i; ?></td>
                                                                            <td align="left" valign="top" width="200" style="padding:2px;  border-bottom:1px #ccc solid;  border-left:1px #ccc solid;"><?= $grievance['grievanceNo']; ?></td>
                                                                            <td align="left" valign="top"  width="150" style="padding:2px; border-bottom:1px #ccc solid;  border-left:1px #ccc solid;"><?= $grievance['name']; ?></td>
                                                                            <td align="left" valign="top" width="200" style="padding:2px; border-bottom:1px #ccc solid;  border-left:1px #ccc solid;"><?= $grievance['address']; ?></td>
                                                                            <td align="left" valign="top" width="100" style="padding:2px; border-bottom:1px #ccc solid;  border-left:1px #ccc solid;"><?= $grievance['grievanceType']; ?></td>
                                                                            <td align="left" valign="top" width="50" style="padding:2px; border-bottom:1px #ccc solid;  border-left:1px #ccc solid;"><?= $grievance['applicationStatus']; ?></td>
                                                                        </tr>
                                                                    </tbody>
                                                                    <?php
                                                                    $i++;
                                                                endforeach;
                                                                ?>
                                                            <?php endif; ?>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="20"><img src="http://demodevelopment.com/security-mailer/spacer-img.png" alt="" width="5" height="20"  border="0" style="display: block;" /></td>
                                                </tr>
                                            </table></td>
                                        <td width="20" valign="middle"><img src="http://demodevelopment.com/security-mailer/spacer-img.png" alt="" width="20" height="10"  border="0" style="display: block;" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" height="20"><img src="http://demodevelopment.com/security-mailer/spacer-img.png" alt="" width="1" height="20"  border="0" style="display: block;" /></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td height="20"><img src="http://demodevelopment.com/security-mailer/spacer-img.png" alt="" width="1" height="20"  border="0" style="display: block;" /></td>
            </tr>
        </table>
    </body>
</html>