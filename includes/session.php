<?php
	class Session{
		private $loggedIn = false;
		private $userId;
		private $avatar_path;
		private $userName;
		private $message = "";

		function __construct(){
			session_start();
			$this->checkLogin();
		}

		public function setMessage($text){
			$this->message = $_SESSION['message'] = $text;
		}

		public function getMessage(){
			$this->message = isset($_SESSION['message']) ? $_SESSION['message'] : "";
			return $this->message;
		}

		public function userId(){
			return $this->userId;
		}

		public function avatarUrl(){
			return $this->avatar_path;
		}

		public function userName(){
			return $this->userName;
		}

		public function isloggedIn(){
			return $this->loggedIn;
		}

		public function login($user){
			if($user){
				$this->userId = $_SESSION['userId'] = $user->id;
			    $this->userName = $_SESSION['userName'] = $user->username;
                $this->avatar_path = $_SESSION['avatar_path'] = $user->avatar_path;
			   	$this->loggedIn = true;
			}
		}

		public function logout(){
			unset($_SESSION['userId']);
		    unset($_SESSION['userName']);
		    unset($_SESSION['message']);
		    unset($_SESSION['avatar_path']);
		    unset($this->userId);
		    unset($this->userName);
		    unset($this->message);
		    unset($this->avatar_path);
		    $this->loggedIn = false;
		}

		private function checkLogIn(){
			if(isset($_SESSION['userName'])){
				$this->userId = $_SESSION['userId'];
				$this->userName = $_SESSION['userName'];
				$this->loggedIn = true;
			}else{
				unset($this->userId);
				unset($this->userName);
				$this->loggedIn = false;
			}
		}
	}

	$session = new Session();


?>