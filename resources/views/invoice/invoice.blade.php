<!doctype html>
            <html lang="en">
            <head>
            <meta charset="UTF-8">
            <title>Invoice</title>

            <style type="text/css">
                * {
                    font-family: Verdana, Arial, sans-serif;
                }
                table{
                    font-size: x-small;
                }
                tfoot tr td{
                    font-weight: bold;
                    font-size: x-small;
                }

                .gray {
                    background-color: lightgray
                }
            </style>

            </head>
            <body>

              <table width="100%">
                <tr>
                    <td valign="top"><img src="{{asset('assets/images/logo.jpg')}}" alt="" width="150"/></td>
                    <td align="right">
                        <h3>Digital Kheops</h3>
                        
                    </td>
                </tr>

              </table>

              <table width="100%">
                <tr>
                    <td><strong>From:</strong> Digital Kheops</td>
                    <td><strong>To:</strong> <?php echo $user_name;?></td>
                    <td><strong>Payment reference:</strong><?php echo $transaction_id;?></td>
                    <td><strong>Date:</strong><?php echo date('Y-m-d'); ?></td>
                </tr>

              </table>

              <br/>

              <table width="100%">
                <thead style="background-color: lightgray;">
                  <tr>
                    <th>Description</th>
                    <th>Unit Price $</th>
                    <th>Total $</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php echo $plan_name;?></td>
                    <td align="right"><?php echo $payment;?></td>
                    <td align="right"><?php echo $payment;?></td>
                  </tr>
                 
                  
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="1"></td>
                        <td align="right"></td>
                        <td align="right" class="gray">$<?php echo $payment;?></td>
                    </tr>
                </tfoot>
              </table>

            </body>
            </html>



            