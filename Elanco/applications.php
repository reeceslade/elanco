<!DOCTYPE html>
<html>
<head>
	<title>Elanco Applications</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>

    img {
      height: 75px;
      width: 75px;
      position: fixed;
      top: 0;
      right: 0;
      margine:100px;
    }
    
		table {
			border-collapse: collapse;
			width: 100%;
		}

		th, td {
			text-align: left;
			padding: 8px;
		}

		tr:nth-child(even){background-color: #f2f2f2}

		th {
			background-color: #4CAF50;
			color: white;
		}
	</style>
</head>
<body>
      
<?php
$api_url = 'https://engineering-task.elancoapps.com/api/applications/';
$applications = json_decode(file_get_contents($api_url), true);

$order = isset($_GET['order']) ? $_GET['order'] : '';
$application_name = isset($_GET['application-name']) ? $_GET['application-name'] : '';

if (!empty($_GET['application-name'])) {
	$resources_url = $api_url . $_GET['application-name'];
	$resources = json_decode(file_get_contents($resources_url), true);
  
    $resources = array();
    if (!empty($application_name)) {
        $resources_url = $api_url . $application_name;
        $resources = json_decode(file_get_contents($resources_url), true);

      if ($order === 'ascending-qty') {
            usort($resources, function ($a, $b) {
                return $b['ConsumedQuantity'] <=> $a['ConsumedQuantity'];
            });
        } else if ($order === 'descending-qty') {
            usort($resources, function ($a, $b) {
                return $a['ConsumedQuantity'] <=> $b['ConsumedQuantity'];
            });
        }
      
            if ($order === 'ascending-cost') {
                usort($resources, function ($a, $b) {
                    return $b['Cost'] <=> $a['Cost'];
                });
            } else if ($order === 'descending-cost') {
                usort($resources, function ($a, $b) {
                    return $a['Cost'] <=> $b['Cost'];
                });
            }
        
            if ($order === 'ascending-date') {
                usort($resources, function ($a, $b) {
                    return $b['Date'] <=> $a['Date'];
                });
            } else if ($order === 'descending-date') {
                usort($resources, function ($a, $b) {
                    return $a['Date'] <=> $b['Date'];
                });
            }
        }
?>
	<h2><?php echo $_GET['application-name']; ?></h2>
  <a href="index.php">
  <img src="https://cdn-icons-png.flaticon.com/512/25/25694.png" alt="Icon">
</a>
	<table>
		<tr>
			<th>Consumed Quantity
   <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="GET">
                    <input type="hidden" name="application-name" value="<?php echo $application_name; ?>">
                    <select name="order" onchange="this.form.submit()">
                        <option value="" disabled selected>Choose an option</option>
                        <option value="ascending-qty" <?php if ($order === 'ascending-qty') echo 'selected'; ?>>Ascending</option>
                        <option value="descending-qty" <?php if ($order === 'descending-qty') echo 'selected'; ?>>Descending</option>
                </select>
               </form>
            </th>
			<th>Cost
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="GET">
                    <input type="hidden" name="application-name" value="<?php echo $application_name; ?>">
                    <select name="order" onchange="this.form.submit()">
                        <option value="" disabled selected>Choose an option</option>
                        <option value="ascending-cost" <?php if ($order === 'ascending-cost') echo 'selected'; ?>>Ascending</option>
                        <option value="descending-cost" <?php if ($order === 'descending-cost') echo 'selected'; ?>>Descending</option>
                </select>
               </form>
            </th>
			<th>Date
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
					<input type="hidden" name="application-name" value="<?php echo $application_name; ?>">
					<select name="order" onchange="this.form.submit()">
						<option value="" disabled selected>Choose an option</option>
						<option value="ascending-date" <?php if ($order === 'ascending-date') echo 'selected'; ?>>Ascending</option>
						<option value="descending-date" <?php if ($order === 'descending-date') echo 'selected'; ?>>Descending</option>
					</select>
				</form>
			</th>
			<th>Instance ID</th>
			<th>Meter Category</th>
			<th>Resource Group</th>
			<th>Resource Location</th>
			<th>Tags</th>
			<th>Unit of Measure</th>
			<th>Location</th>
			<th>Service Name</th>
		</tr>
		<?php foreach ($resources as $resource) { ?>
		<tr>
			<td><?php echo $resource['ConsumedQuantity']; ?></td>
			<td><?php echo $resource['Cost']; ?></td>
			<td><?php echo $resource['Date']; ?></td>
			<td><?php echo $resource['InstanceId']; ?></td>
			<td>
				<?php $meter_category_url = 'https://elanco.reeceslade.repl.co/resources.php?resource-name=' . urlencode($resource['MeterCategory']); ?>
				<a href="<?php echo $meter_category_url; ?>"><?php echo $resource['MeterCategory']; ?></a>
			</td>
			<td><?php echo $resource['ResourceGroup']; ?></td>
			<td><?php echo $resource['ResourceLocation']; ?></td>
      <td>
			<?php 
      $tags = $resource['Tags'];
      $formattedTags = '';
      foreach ($tags as $key => $value) {
        $formattedTags .= $key . ': ' . $value . '<br>';
      }
      echo $formattedTags; ?>
     </td>
			<td><?php echo $resource['UnitOfMeasure']; ?></td>
			<td><?php echo $resource['Location']; ?></td>
			<td><?php echo $resource['ServiceName']; ?></td>
		</tr>
		<?php } ?>
	</table>
<?php
}
?>
<h2>Applications</h2>
  <a href="index.php">
  <img src="https://cdn-icons-png.flaticon.com/512/25/25694.png" alt="Icon">
</a>
<table>
	<tr>
		<th>Application Name</th>
		<th>Actions</th>
	</tr>
	<?php foreach ($applications as $application) { ?>
		<tr>
			<td><?php echo $application; ?></td>
			<td>
				<form action="" method="GET">
					<input type="hidden" name="application-name" value="<?php echo $application; ?>">
					<button type="submit">View Resources</button>
				</form>
			</td>
		</tr>
	<?php } ?>
</table>
</body>
</html>
