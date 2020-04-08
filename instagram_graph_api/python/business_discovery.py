from defines import getCreds, makeApiCall

def getAccountInfo( params ) :
	""" Get info on a users account
	
	API Endpoint:
		https://graph.facebook.com/{graph-api-version}/{ig-user-id}?fields=business_discovery.username({ig-username}){username,website,name,ig_id,id,profile_picture_url,biography,follows_count,followers_count,media_count}&access_token={access-token}

	Returns:
		object: data from the endpoint

	"""

	endpointParams = dict()
	endpointParams['fields'] = 'business_discovery.username(' + params['ig_username'] + '){username,website,name,ig_id,id,profile_picture_url,biography,follows_count,followers_count,media_count}'
	endpointParams['access_token'] = params['access_token']

	url = params['endpoint_base'] + params['instagram_account_id']

	return makeApiCall( url, endpointParams, params['debug'] )

params = getCreds()
params['debug'] = 'no'
response = getAccountInfo( params )

print "\n---- ACCOUNT INFO -----\n"
print "username:"
print response['json_data']['business_discovery']['username']
print "\nwebsite:"
print response['json_data']['business_discovery']['website']
print "\nnumber of posts:"
print response['json_data']['business_discovery']['media_count']
print "\nfollowers:"
print response['json_data']['business_discovery']['followers_count']
print "\nfollowing:"
print response['json_data']['business_discovery']['follows_count']
print "\nprofile picture url:"
print response['json_data']['business_discovery']['profile_picture_url']
print "\nbiography:"
print response['json_data']['business_discovery']['biography']