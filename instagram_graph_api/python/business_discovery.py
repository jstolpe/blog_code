from defines import getCreds, makeApiCall

def getAccountInfo( params ) :
	""" Get info on a users account
	
	API Endpoint:
		https://graph.facebook.com/{graph-api-version}/{ig-user-id}?fields=business_discovery.username({ig-username}){username,website,name,ig_id,id,profile_picture_url,biography,follows_count,followers_count,media_count}&access_token={access-token}

	Returns:
		object: data from the endpoint

	"""

	endpointParams = dict() # parameter to send to the endpoint
	endpointParams['fields'] = 'business_discovery.username(' + params['ig_username'] + '){username,website,name,ig_id,id,profile_picture_url,biography,follows_count,followers_count,media_count}' # string of fields to get back with the request for the account
	endpointParams['access_token'] = params['access_token'] # access token

	url = params['endpoint_base'] + params['instagram_account_id'] # endpoint url

	return makeApiCall( url, endpointParams, params['debug'] ) # make the api call

params = getCreds() # get creds
params['debug'] = 'no' # set debug
response = getAccountInfo( params ) # hit the api for some data!

print "\n---- ACCOUNT INFO -----\n" # display latest post info
print "username:" # label
print response['json_data']['business_discovery']['username'] # display username
print "\nwebsite:" # label
print response['json_data']['business_discovery']['website'] # display users website
print "\nnumber of posts:" # label
print response['json_data']['business_discovery']['media_count'] # display number of posts user has made
print "\nfollowers:" # label
print response['json_data']['business_discovery']['followers_count'] # display number of followers the user has
print "\nfollowing:" # label
print response['json_data']['business_discovery']['follows_count'] # display number of people the user follows
print "\nprofile picture url:" # label
print response['json_data']['business_discovery']['profile_picture_url'] # display profile picutre url
print "\nbiography:" # label
print response['json_data']['business_discovery']['biography'] # display users about section