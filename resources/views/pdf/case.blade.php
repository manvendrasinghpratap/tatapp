<center style="background-color:#D3D3D3; height: 50px;"><p style=" padding-top: 14px;">{{ @$data['insertOrUpdate']  }}</p></center>
<table class="table-bordered">
        <tr>
            <td class="left" >Status:</td>
            <td class="right">{{ucfirst(@$data['caseDetails']->status)}}</td>
        </tr >
        <tr>
            <td class="left">Summary Rank:</td>
            <td class="right"> 
                <?php  
                $rank_sum = 0; 
                if(isset($data['getAllSectorByCaseId'])&&!empty($data['getAllSectorByCaseId'])){
                    $total_rank_data = count($data['getAllSectorByCaseId']);
                    $avg_rank = 0;
                    if($total_rank_data>0){
                        foreach($data['getAllSectorByCaseId'] as $row) {
                            $rank_sum = $rank_sum+ $row->rank_id;
                        }  
                    }
                    if($total_rank_data>0){
                        $avg_rank = $rank_sum / $total_rank_data;
                    }
                    echo number_format($avg_rank,2).'/10';
                } else{
                    echo '0/10';
                } ?>
            </td>
        </tr>
        <tr>
            <td class="left">Urgency:</td>
            <td class="right">  {{@$data['caseDetails']->urgency}}</td>
        </tr>
       <tr>
            <td class="left">User owner:</td>
            <td class="right">  
           {{@$data['case_owner_name']}}
            </td>
        </tr>
        <tr>
            <td class="left">Description:</td>
            <td class="right">
                <p style="word-break: break-all; word-wrap: break-word;">{{@$data['caseDetails']->description}}</p>
            </td>
        </tr>
        <tr>
            <td class="left">Date:</td>
            <td class="right">
                <p style="word-break: break-all; word-wrap: break-word;">{{@$data['caseDetails']->created_at}}</p>
            </td>
        </tr>
</table>
