from defines import getCreds, makeApiCall
import datetime

def debugAccessToken( params ) :
	""" Get info on an access token 
	
	API Endpoint:
		https://graph.facebook.com/debug_token?input_token={input-token}&access_token={valid-access-token}

	Returns:
		object: data from the endpoint

	"""

	endpointParams = dict() # parameter to send to the endpoint
	endpointParams['input_token'] = params['access_token'] # input token is the access token
	endpointParams['access_token'] = params['access_token'] # access token to get debug info on

	url = params['graph_domain'] + '/debug_token' # endpoint url

	return makeApiCall( url, endpointParams, params['debug'] ) # make the api call

params = getCreds() # get creds
params['debug'] = 'yes' # set debug
response = debugAccessToken( params ) # hit the api for some data!

print "\nData Access Expires at: " # label
print datetime.datetime.fromtimestamp( response['json_data']['data']['data_access_expires_at'] ) # display out when the token expires

print "\nToken Expires at: " # label
print datetime.datetime.fromtimestamp( response['json_data']['data']['expires_at'] ) # display out when the token expires