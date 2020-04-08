import requests
import json

def getCreds() :
	creds = dict()
	creds['access_token'] = 'ACCESS-TOKEN'
	creds['client_id'] = 'FB-APP-CLIENT-ID'
	creds['client_secret'] = 'FB-APP-CLIENT-SECRET'
	creds['graph_domain'] = 'https://graph.facebook.com/'
	creds['graph_version'] = 'v6.0'
	creds['endpoint_base'] = creds['graph_domain'] + creds['graph_version'] + '/'
	creds['debug'] = 'no'
	creds['page_id'] = 'FB-PAGE-ID'
	creds['instagram_account_id'] = 'INSTAGRAM-BUSINESS-ACCOUNT-ID'
	creds['ig_username'] = 'IG-USERNAME'

	return creds

def makeApiCall( url, endpointParams, debug = 'no' ) :
	data = requests.get( url, endpointParams )

	response = dict()
	response['url'] = url
	response['endpoint_params'] = endpointParams
	response['endpoint_params_pretty'] = json.dumps( endpointParams, indent = 4 )
	response['json_data'] = json.loads( data.content )
	response['json_data_pretty'] = json.dumps( response['json_data'], indent = 4 )

	if ( 'yes' == debug ) :
		displayApiCallData( response )

	return response

def displayApiCallData( response ) :
	print "\nURL: "
	print response['url']
	print "\nEndpoint Params: "
	print response['endpoint_params_pretty']
	print "\nResponse: "
	print response['json_data_pretty']