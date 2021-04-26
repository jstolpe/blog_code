import time
from defines_py3 import getCreds, makeApiCall

def createMediaObject( params ) :
	""" Create media object

	Args:
		params: dictionary of params
	
	API Endpoint:
		https://graph.facebook.com/v5.0/{ig-user-id}/media?image_url={image-url}&caption={caption}&access_token={access-token}
		https://graph.facebook.com/v5.0/{ig-user-id}/media?video_url={video-url}&caption={caption}&access_token={access-token}

	Returns:
		object: data from the endpoint

	"""

	url = params['endpoint_base'] + params['instagram_account_id'] + '/media' # endpoint url

	endpointParams = dict() # parameter to send to the endpoint
	endpointParams['caption'] = params['caption']  # caption for the post
	endpointParams['access_token'] = params['access_token'] # access token

	if 'IMAGE' == params['media_type'] : # posting image
		endpointParams['image_url'] = params['media_url']  # url to the asset
	else : # posting video
		endpointParams['media_type'] = params['media_type']  # specify media type
		endpointParams['video_url'] = params['media_url']  # url to the asset
	
	return makeApiCall( url, endpointParams, 'POST' ) # make the api call

def getMediaObjectStatus( mediaObjectId, params ) :
	""" Check the status of a media object

	Args:
		mediaObjectId: id of the media object
		params: dictionary of params
	
	API Endpoint:
		https://graph.facebook.com/v5.0/{ig-container-id}?fields=status_code

	Returns:
		object: data from the endpoint

	"""

	url = params['endpoint_base'] + '/' + mediaObjectId # endpoint url

	endpointParams = dict() # parameter to send to the endpoint
	endpointParams['fields'] = 'status_code' # fields to get back
	endpointParams['access_token'] = params['access_token'] # access token

	return makeApiCall( url, endpointParams, 'GET' ) # make the api call

def publishMedia( mediaObjectId, params ) :
	""" Publish content

	Args:
		mediaObjectId: id of the media object
		params: dictionary of params
	
	API Endpoint:
		https://graph.facebook.com/v5.0/{ig-user-id}/media_publish?creation_id={creation-id}&access_token={access-token}

	Returns:
		object: data from the endpoint

	"""

	url = params['endpoint_base'] + params['instagram_account_id'] + '/media_publish' # endpoint url

	endpointParams = dict() # parameter to send to the endpoint
	endpointParams['creation_id'] = mediaObjectId # fields to get back
	endpointParams['access_token'] = params['access_token'] # access token

	return makeApiCall( url, endpointParams, 'POST' ) # make the api call

def getContentPublishingLimit( params ) :
	""" Get the api limit for the user

	Args:
		params: dictionary of params
	
	API Endpoint:
		https://graph.facebook.com/v5.0/{ig-user-id}/content_publishing_limit?fields=config,quota_usage

	Returns:
		object: data from the endpoint

	"""

	url = params['endpoint_base'] + params['instagram_account_id'] + '/content_publishing_limit' # endpoint url

	endpointParams = dict() # parameter to send to the endpoint
	endpointParams['fields'] = 'config,quota_usage' # fields to get back
	endpointParams['access_token'] = params['access_token'] # access token

	return makeApiCall( url, endpointParams, 'GET' ) # make the api call

params = getCreds() # get creds from defines

params['media_type'] = 'IMAGE' # type of asset
params['media_url'] = 'https://justinstolpe.com/sandbox/ig_publish_content_img.png' # url on public server for the post
params['caption'] = 'This image was posted through the Instagram Graph API with a python script I wrote! Go check out the video tutorial on my YouTube channel.'
params['caption'] += "\n."
params['caption'] += "\nyoutube.com/justinstolpe"
params['caption'] += "\n."
params['caption'] += "\n#instagram #graphapi #instagramgraphapi #code #coding #programming #python #api #webdeveloper #codinglife #developer #coder #tech #developerlife #webdev #youtube #instgramgraphapi" # caption for the post

imageMediaObjectResponse = createMediaObject( params ) # create a media object through the api
imageMediaObjectId = imageMediaObjectResponse['json_data']['id'] # id of the media object that was created
imageMediaStatusCode = 'IN_PROGRESS';

print( "\n---- IMAGE MEDIA OBJECT -----\n" ) # title
print( "\tID:" ) # label
print( "\t" + imageMediaObjectId ) # id of the object

while imageMediaStatusCode != 'FINISHED' : # keep checking until the object status is finished
	imageMediaObjectStatusResponse = getMediaObjectStatus( imageMediaObjectId, params ) # check the status on the object
	imageMediaStatusCode = imageMediaObjectStatusResponse['json_data']['status_code'] # update status code

	print( "\n---- IMAGE MEDIA OBJECT STATUS -----\n" ) # display status response
	print( "\tStatus Code:" ) # label
	print( "\t" + imageMediaStatusCode ) # status code of the object

	time.sleep( 5 ) # wait 5 seconds if the media object is still being processed

publishImageResponse = publishMedia( imageMediaObjectId, params ) # publish the post to instagram

print( "\n---- PUBLISHED IMAGE RESPONSE -----\n" ) # title
print( "\tResponse:" ) # label
print( publishImageResponse['json_data_pretty'] ) # json response from ig api

params['media_type'] = 'VIDEO' # type of asset
params['media_url'] = 'https://justinstolpe.com/sandbox/ig_publish_content_vid.mp4' # url on public server for the post
params['caption'] = 'This video was posted through the Instagram Graph API with a python script I wrote! Go check out the video tutorial on my YouTube channel.'
params['caption'] += "\n."
params['caption'] += "\nyoutube.com/justinstolpe"
params['caption'] += "\n."
params['caption'] += "\n#instagram #graphapi #instagramgraphapi #code #coding #programming #python #api #webdeveloper #codinglife #developer #coder #tech #developerlife #webdev #youtube #instgramgraphapi" # caption for the post

videoMediaObjectResponse = createMediaObject( params ) # create a media object through the api
videoMediaObjectId = videoMediaObjectResponse['json_data']['id'] # id of the media object that was created
videoMediaStatusCode = 'IN_PROGRESS';

print( "\n---- VIDEO MEDIA OBJECT -----\n" ) # title
print( "\tID:" ) # label
print( "\t" + videoMediaObjectId ) # id of the object

while videoMediaStatusCode != 'FINISHED' : # keep checking until the object status is finished
	videoMediaObjectStatusResponse = getMediaObjectStatus( videoMediaObjectId, params ) # check the status on the object
	videoMediaStatusCode = videoMediaObjectStatusResponse['json_data']['status_code'] # update status code

	print( "\n---- VIDEO MEDIA OBJECT STATUS -----\n" ) # display status response
	print( "\tStatus Code:" ) # label
	print( "\t" + videoMediaStatusCode ) # status code of the object

	time.sleep( 5 ) # wait 5 seconds if the media object is still being processed

publishVideoResponse = publishMedia( videoMediaObjectId, params ) # publish the post to instagram

print( "\n---- PUBLISHED IMAGE RESPONSE -----\n" ) # title
print( "\tResponse:" ) # label
print( publishVideoResponse['json_data_pretty'] ) # json response from ig api

contentPublishingApiLimit = getContentPublishingLimit( params ) # get the users api limit

print( "\n---- CONTENT PUBLISHING USER API LIMIT -----\n" ) # title
print( "\tResponse:" ) # label
print( contentPublishingApiLimit['json_data_pretty'] ) # json response from ig api