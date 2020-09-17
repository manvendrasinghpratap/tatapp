<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>TADapp Task Reminder for (title of Incident) : (title of Task)</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body style="padding: 10px; background-color: #e6e6e6;">
<table style="width: 100%; margin: 0; padding: 0;" border="0">
    <tr>
        <td style="background-color: #ffffff; border-bottom: 1px solid #e6e6e6; padding: 20px 10px;">
            <span style="color: #333; font-size: 25px;">TADapp Task Reminder for <?php echo $data['taskDetailsArray']->incidenttasks[0]->incident->title; ?> : <?php echo $data['taskDetailsArray']->title; ?></span>
        </td>
    </tr>
    <tr>
        <td style="background-color: #ffffff; border-bottom: 1px solid #e6e6e6; padding: 20px 10px; font-size: 17px;">
                Hello <?php echo $data['user']->first_name; ?>,<br/>
                <p>You have been assigned the following Task : </p>
                <p><strong>Title of Incident: </strong><?php echo $data['taskDetailsArray']->incidenttasks[0]->incident->title; ?></p>
                <p><strong>Task Title: </strong> <?php echo $data['taskDetailsArray']->title ; ?></p>
                <p><strong>Description: </strong> <?php echo $data['taskDetailsArray']->description; ?> </p>
                <p><strong>Due Date: </strong> <?php echo date("F j, Y", strtotime($data['taskDetailsArray']->due_date)); ?></p>
                <p><strong>User Assigned: </strong> <?php echo $data['user']->first_name." ".$data['user']->last_name; ?> </p>
            <br/>
            Thanks! <br/>
            TADapp Team            
            <br/>
        </td>
    </tr>
    <tr>
        <td style="background-color: #ffffff; border-bottom: 1px solid #e6e6e6; padding: 20px 10px; text-align: center;">
            <span style="font-size: 15px;">Copyright &copy; <?php echo date('Y') ?></span>
        </td>
    </tr>
</table>
</body>
</html>