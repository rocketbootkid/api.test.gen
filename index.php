<html>
<head>
	<title>rcpaterson.co.uk</title>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>

<div id="container">
    
	<?php

		// https://apis.guru/browse-apis/

		$url = "https://api.apis.guru/v2/specs/slack.com/1.0.0/swagger.json";
		//$url = "https://api.apis.guru/v2/specs/xkcd.com/1.0.0/swagger.json";
		//$url = "https://api.apis.guru/v2/specs/bbci.co.uk/1.0/swagger.json";
		
		$json = getSwaggerJSON($url);
		$path_count = count($json["paths"]);
		$paths = $json["paths"];
		
		while ($endpoint = current($paths)) {
			
			echo "<table cellpadding=3 cellspacing=1 border=1 width=700px>";
			
			// Endpoint URL
			$endpoint_name = key($paths);
			echo "<tr><td width=100px>Endpoint<td>" . $endpoint_name . "</tr>";
			
			// Verb
			$endpoint_verb = key($endpoint);
			echo "<tr><td>Verb<td>" . strtoupper($endpoint_verb) . "</tr>";

			// Description
			$endpoint_description = $endpoint[$endpoint_verb]["description"];
			echo "<tr><td>Description<td>" . $endpoint_description . "</tr>";
			
			// Parameters
			echo "<tr><td>Parameters<td>";
			$parameters = $endpoint[$endpoint_verb]["parameters"];
			$endpoint_parameters = extractParameters($parameters);
			echo $endpoint_parameters;
			echo "</tr>";
						
			// Responses
			echo "<tr><td>Responses<td>";
			$responses = $endpoint[$endpoint_verb]["responses"];
			$endpoint_responses = extractResponses($responses);
			echo $endpoint_responses;
			echo "</tr>";			
			
			
			echo "</table><p>";
			
			next($paths);

		}
		
		function getSwaggerJSON($url) {
			
			$file_contents = file_get_contents($url);
			$json = json_decode($file_contents, true);
		
			return $json;
			
		}
		
		function extractParameters($parameters) {
			
			$parameter_text = "<table cellpadding=2 cellspacing=1 border=1 width=100%>";
			$parameters_count = count($parameters);
			if ($parameters) {
				$parameter_text = $parameter_text . "<tr><td colspan=3>There are " . $parameters_count . " parameter(s).</tr>";
				while ($parameter = current($parameters)) {
					
					$parameter_name = $parameter["name"];
					$parameter_type = $parameter["type"];
					$parameter_description = $parameter["description"];
					if ($parameter_description == "") {
						$parameter_description = "[No Description]";
					}
					
					$parameter_text = $parameter_text . "<tr><td width=100>" . $parameter_name . "<td>" . $parameter_type . "<td>" . $parameter_description . "</tr>";
					
					next($parameters);
				}	
			} else {
				$parameter_text = $parameter_text . "<tr><td>This endpoint has no parameters.</tr>";
			}
			$parameter_text = $parameter_text . "</table>";
			
			return $parameter_text;
			
		}
		
		function extractResponses($responses) {
			
			$response_text = "<table cellpadding=2 cellspacing=1 border=1 width=100%>";
			$responses_count = count($responses);
			if ($responses) {
				$response_text = $response_text . "<tr><td colspan=3>There are " . $responses_count . " response(s).</tr>";
				while ($response = current($responses)) {
					
					$response_http_code = key($responses);			
					$response_description = $response["description"];
					$response_schema = $response["schema"]["\$ref"];
					
					$response_text = $response_text . "<tr><td width=100>HTTP " . $response_http_code . "<td>" . $response_description . "<td>" . $response_schema . "</tr>";
					
					next($responses);
				}	
			} else {
				$response_text = $response_text . "<tr><td>This endpoint has no responses.</tr>";
			}
			$response_text = $response_text . "</table>";
			
			return $response_text;
			
			
		}
		
		function extractResponseSchema($ref) {
			
			
			
			
		}

	?>
	
</div>

</body>
</html>