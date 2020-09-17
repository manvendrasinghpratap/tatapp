<center style="background-color:#D3D3D3; height: 50px;"><p style=" padding-top: 14px;">{{ @$data['incidentInsertOrDelete']  }}: {{ \Carbon\Carbon::parse(@$data['linked_date'])->format('F j, Y H:i s')}} </p></center>
    
    <table class="table-bordered" style="width:100%">
        <tbody>
            <tr>
                <td class="left">Title</td> 
                <td class="right"><?php echo $data['incidentDetails']->title; ?></td>
            </tr>
            <tr>
                <td class="left">Description</td>
                <td class="right">
                    <p style="word-wrap: break-word; word-break: break-all;"><?php echo $data['incidentDetails']->description; ?></p>
                </td>
            </tr>
            <tr>
                <td class="left">Type</td>
                <td class="right"><?php echo $data['incidentDetails']->type; ?></td>

                </tr>
            <tr>
                <td class="left">Incident Date/Time</td> 
                <td class="right">{{date("F j, Y H:i", strtotime($data['incidentDetails']->incident_datetime))}}</td>
                </tr>

            <tr>
                <td class="left">Created TimeStamp</td> 
                <td class="right">{{date("F j, Y H:i", strtotime($data['incidentDetails']->created_at))}}</td>
           </tr>
           <tr>
                <td class="left">Location</td> 
                <td class="right"><?php echo $data['incidentDetails']->location; ?></td>
           </tr>
           <tr>
                <td class="left">Reported By</td> 
                <td class="right"><?php echo $data['incidentDetails']->reported_by; ?></td>
           </tr>
            <tr>
                <td class="left">Date of Report</td> 
                <td class="right">{{date("F j, Y H:i", strtotime($data['incidentDetails']->date_of_report))}}</td>
           </tr>
        </tbody>
    </table>
