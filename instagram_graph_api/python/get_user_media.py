from defines import getCreds, makeApiCall

def getUserMedia( params, pagingUrl = '' ) :
	""" Get users media
	
	API Endpoint:
		https://graph.facebook.com/{graph-api-version}/{ig-user-id}/media?fields={fields}&access_token={access-token}

	Returns:
		object: data from the endpoint

	"""

	endpointParams = dict()
	endpointParams['fields'] = 'id,caption,media_type,media_url,permalink,thumbnail_url,timestamp,username'
	endpointParams['access_token'] = params['access_token']

	if ( '' == pagingUrl ) : 
		url = params['endpoint_base'] + params['instagram_account_id'] + '/media'
	else :
		url = pagingUrl

	return makeApiCall( url, endpointParams, params['debug'] )

params = getCreds()
params['debug'] = 'no'
response = getUserMedia( params )

print "\n\n\n\t\t\t >>>>>>>>>>>>>>>>>>>> PAGE 1 <<<<<<<<<<<<<<<<<<<<\n"

for post in response['json_data']['data'] :
	print "\n\n---------- POST ----------\n"
	print "Link to post:"
	print post['permalink']
	print "\nPost caption:"
	print post['caption']
	print "\nMedia type:"
	print post['media_type']
	print "\nPosted at:"
	print post['timestamp']

params['debug'] = 'no'
response = getUserMedia( params, response['json_data']['paging']['next'] )

print "\n\n\n\t\t\t >>>>>>>>>>>>>>>>>>>> PAGE 2 <<<<<<<<<<<<<<<<<<<<\n"

for post in response['json_data']['data'] :
	print "\n\n---------- POST ----------\n"
	print "Link to post:"
	print post['permalink']
	print "\nPost caption:"
	print post['caption']
	print "\nMedia type:"
	print post['media_type']
	print "\nPosted at:"
	print post['timestamp']