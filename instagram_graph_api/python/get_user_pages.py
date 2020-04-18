from defines import getCreds, makeApiCall

def getUserPages( params ) :
	""" Get facebook pages for a user
	
	API Endpoint:
		https://graph.facebook.com/{graph-api-version}/me/accounts?access_token={access-token}

	Returns:
		object: data from the endpoint

	"""

	endpointParams = dict() # parameter to send to the endpoint
	endpointParams['access_token'] = params['access_token'] # access token

	url = params['endpoint_base'] + 'me/accounts' # endpoint url

	return makeApiCall( url, endpointParams, params['debug'] ) # make the api call

params = getCreds() # get creds
params['debug'] = 'no' # set debug
response = getUserPages( params ) # get debug info

print "\n---- FACEBOOK PAGE INFO ----\n" # section heading
print "Page Name:" # label
print response['json_data']['data'][0]['name'] # display name
print "\nPage Category:" # label
print response['json_data']['data'][0]['category'] # display category
print "\nPage Id:" # label
print response['json_data']['data'][0]['id'] # display id