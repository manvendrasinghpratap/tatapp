<center style="background-color:#D3D3D3; height: 50px;"><p style=" padding-top: 14px;">{{ @$data['taskinsertOrUpdate']  }}</p></center>

<table class="table-bordered">
    <tbody>
        <tr>
            <td class="left">Title :</td> 
            <td class="right"><?php echo $data['taskDetails']->title; ?></td>
        </tr>
        <tr>
            <td class="left">Description</td>
            <td class="right"><p style="word-wrap: break-word; word-break: break-all;"><?php echo $data['taskDetails']->description; ?></p></td>
        </tr>
        <tr>
            <td class="left">User Assigned</td>
            <td class="right"><?php echo $data['taskDetails']->user->first_name." ".$data['taskDetails']->user->last_name; ?></td>
        </tr>
        <tr>
            <td class="left">Status</td> 
            <td class="right"><?php echo getStatusTitle($data['taskDetails']->status); ?></td>
        </tr>
        <tr>
            <td class="left">Due date</td>
            <td class="right"><?php echo date("F j, Y", strtotime($data['taskDetails']->due_date)); ?></td>
        </tr>
    </tbody>
</table>
