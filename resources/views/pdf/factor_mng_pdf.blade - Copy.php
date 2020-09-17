<center style="background-color:#D3D3D3; height: 50px;"><p style=" padding-top: 14px;">{{ @$data['factorinsertOrUpdate']  }}: {{ \Carbon\Carbon::parse(@$data['factorDetails']->created_at)->format('d-m-Y H:i:s')}} </p></center>
<table class="table-bordered">
    <tbody>
        <tr>
            <td class="left">Title</td> 
            <td class="right"><?php echo $data['factorDetails']->title; ?></td>
        </tr>
        <tr> 
            <td class="left">Occurrence Date</td> 
            <td class="right"><?php echo date("F j, Y", strtotime($data['factorDetails']->occurance_date)); ?></td>
        </tr>
        <tr>
            <td class="left">Rank</td>
            <td class="right"><?php echo $data['factorDetails']->rank_id; ?></td>

        </tr>
        <tr>
            <td class="left">Sector</td>
            <td class="right"><?php echo $data['factorDetails']->sector->sector_name; ?></td>
        </tr>

        <tr>
            <td class="left">Source</td> 
            <td class="right"><?php echo $data['factorDetails']->source; ?></td>
        </tr>
        <tr>
            <td class="left">Description</td>
            <td class="right">
                <p style="word-break: break-all; word-wrap: break-word;"><?php echo $data['factorDetails']->description; ?></p>
            </td>
        </tr>

    </tbody>
</table>
