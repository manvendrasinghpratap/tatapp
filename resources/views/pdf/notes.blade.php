<center style="background-color:#D3D3D3; height: 50px;"><p style=" padding-top: 14px;">{{ @$data['notesinserted']  }}: {{ \Carbon\Carbon::parse(@$data['notesDetails']->modified_time)->format('d-m-Y H:i:s')}} </p></center>
<table class="table-bordered">
    <tr>
            <td class="left">Notes :</td>
            <td class="right">
                <p style="word-break: break-all; word-wrap: break-word;">{{@$data['notesDetails']->add_note}}</p>
            </td>
        </tr>
        <tr>
            <td class="left">Notes Added By :</td>
            <td class="right"> {{@$data['notesDetails']->user->first_name }} {{@$data['notesDetails']->user->last_name }}</td>
        </tr>
        
</table>
