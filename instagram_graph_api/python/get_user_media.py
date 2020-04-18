from defines import getCreds, makeApiCall

def getUserMedia( params, pagingUrl = '' ) :
	""" Get users media
	
	API Endpoint:
		https://graph.facebook.com/{graph-api-version}/{ig-user-id}/media?fields={fields}&access_token={access-token}

	Returns:
		object: data from the endpoint

	"""

	endpointParams = dict() # parameter to send to the endpoint
	endpointParams['fields'] = 'id,caption,media_type,media_url,permalink,thumbnail_url,timestamp,username' # fields to get back
	endpointParams['access_token'] = params['access_token'] # access token

	if ( '' == pagingUrl ) : # get first page
		url = params['endpoint_base'] + params['instagram_account_id'] + '/media' # endpoint url
	else : # get specific page
		url = pagingUrl  # endpoint url

	return makeApiCall( url, endpointParams, params['debug'] ) # make the api call

params = getCreds() # get creds
params['debug'] = 'no' # set debug
response = getUserMedia( params ) # get users media from the api

print "\n\n\n\t\t\t >>>>>>>>>>>>>>>>>>>> PAGE 1 <<<<<<<<<<<<<<<<<<<<\n" # display page 1 of the posts

for post in response['json_data']['data'] :
	print "\n\n---------- POST ----------\n" # post heading
	print "Link to post:" # label
	print post['permalink'] # link to post
	print "\nPost caption:" # label
	print post['caption'] # post caption
	print "\nMedia type:" # label
	print post['media_type'] # type of media
	print "\nPosted at:" # label
	print post['timestamp'] # when it was posted

params['debug'] = 'no' # set debug
response = getUserMedia( params, response['json_data']['paging']['next'] ) # get next page of posts from the api

print "\n\n\n\t\t\t >>>>>>>>>>>>>>>>>>>> PAGE 2 <<<<<<<<<<<<<<<<<<<<\n" # display page 2 of the posts

for post in response['json_data']['data'] :
	print "\n\n---------- POST ----------\n" # post heading
	print "Link to post:" # label
	print post['permalink'] # link to post
	print "\nPost caption:" # label
	print post['caption'] # post caption
	print "\nMedia type:" # label
	print post['media_type'] # type of media
	print "\nPosted at:" # label
	print post['timestamp'] # when it was posted