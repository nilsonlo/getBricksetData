<?php
require_once '../google-api-php-client/src/Google_Client.php';
require_once '../google-api-php-client/src/contrib/Google_DriveService.php';

class MyGoogleDrive {
	var $_client = null;
	var $_service = null;
	function __construct() {
		$this->_client = new Google_Client();
		// Get your credentials from the console
		$this->_client->setClientId('961764646278-rno5smnvlmpfgrganrgh6m0mvickkco3.apps.googleusercontent.com');
		$this->_client->setClientSecret('pYruvAIDe4G_FOhJZSgfJ9Hv');
		$this->_client->setRedirectUri('urn:ietf:wg:oauth:2.0:oob');
		$this->_client->setScopes(array('https://www.googleapis.com/auth/drive',
				'https://www.googleapis.com/auth/drive.file',
				'https://www.googleapis.com/auth/drive.appdata',
				'https://www.googleapis.com/auth/drive.apps.readonly',
				'https://www.googleapis.com/auth/drive.metadata.readonly'));
		$this->_client->setUseObjects(true);
		$this->_service = new Google_DriveService($this->_client);
		$this->_client->setAccessToken(file_get_contents('token.json'));
	}

	function insertFile($title, $description, $parentId, $mimeType, $filename) {
		$file = new Google_DriveFile();
		$file->setTitle($title);
		$file->setDescription($description);
		$file->setMimeType($mimeType);

		// Set the parent folder.
		if ($parentId != null) {
			$parent = new Google_ParentReference();
			$parent->setId($parentId);
			$file->setParents(array($parent));
		}

		try {
			$data = file_get_contents($filename);

			$createdFile = $this->_service->files->insert($file, array(
				'data' => $data,
				'mimeType' => $mimeType,
				));

			// Uncomment the following line to print the File ID
			// print 'File ID: %s' % $createdFile->getId();

			return $createdFile;
		} catch (Exception $e) {
			print "An error occurred: " . $e->getMessage();
		}
	}

	function downloadFile($fileId) {
		try {
			$fileObj = $this->_service->files->get($fileId);
			$downloadUrl = $fileObj->getDownloadUrl();
			if ($downloadUrl) {
				$request = new Google_HttpRequest($downloadUrl, 'GET', null, null);
				$httpRequest = Google_Client::$io->authenticatedRequest($request);
				if ($httpRequest->getResponseHttpCode() == 200) {
					return $httpRequest->getResponseBody();
				} else {
					// An error occurred.
					return null;
				}
			} else {
				// The file doesn't have any content stored on Drive.
				return null;
			}
		} catch (Exception $e) {
			print "An error occurred: " . $e->getMessage();
			return null;
		}
	}

	function GetFilesMeta($fileId) {
		try {
			return $this->_service->files->get($fileId);
		} catch (Exception $e) {
			print "An error occurred: ". $e->getMessage();
			return NULL;
		}
	}

	function FindFolderID($search_key) {
		$result = array();
		$pageToken = NULL;
		do {
			try {
				$parameters = array('q'=>$search_key);
				if ($pageToken) {
					$parameters['pageToken'] = $pageToken;
				}
				$files = $this->_service->files->listFiles($parameters);
				$result = array_merge($result, $files->getItems());
				$pageToken = $files->getNextPageToken();
			} catch (Exception $e) {
				print "An error occurred: " . $e->getMessage();
				$pageToken = NULL;
			}
		} while ($pageToken);
		return $result;
	}

	function ListFileInFolder($folderId) {
		$result = array();
		$pageToken = NULL;
		do {
			try {
				$parameters = array();
				if ($pageToken) {
					$parameters['pageToken'] = $pageToken;
				}
				$files = $this->_service->children->listChildren($folderId,$parameters);
				$result = array_merge($result, $files->getItems());
				$pageToken = $files->getNextPageToken();
			} catch (Exception $e) {
				print "An error occurred: " . $e->getMessage();
				$pageToken = NULL;
			}
		} while ($pageToken);
		return $result;
	}

	function DeleteFileInFolder($folderId,$fileId) {
		try{
			$this->_service->children->delete($folderId,$fileId);
			return true;
		} catch (Exception $e) {
			print "An error occurred: " . $e->getMessage();
			return false;
		}
	}

	function RemoveFileFromFolder($folderId,$fileId) {
		try{
			$this->_service->parents->delete($fileId,$folderId);
			return true;
		} catch (Exception $e) {
			print "An error occurred: " . $e->getMessage();
			return false;
		}
	}

	function InsertFileIntoFolder($folderId,$fileId) {
		$newParent = new Google_ParentReference();
		$newParent->setId($folderId);
		try{
			return $this->_service->parents->insert($fileId,$newParent);
		} catch (Exception $e) {
			print "An error occurred: " . $e->getMessage();
		}
		return NULL;
	}
}
?>
