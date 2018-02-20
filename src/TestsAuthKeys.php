<?php

namespace Zoomyboy\KeyAuth;

use Zoomyboy\KeyAuth\AuthKey;

trait TestsAuthKeys {
	public function assertAuthKeyFor($link, $user) {
		$this->assertEquals(1, preg_match('#^/auth/key/.+#', str_replace(config('app.url'), '', $link)), 'Auth link assertion failed. Given Auth-URL is not a real Auth-Link');
		preg_match_all('#/auth/key/([^/]+)\?url=(.+)$#', $link, $matches);
		$key = $matches[1][0];
		$authKey = AuthKey::where('key', $key)->first();
		$this->assertNotNull($authKey);
		$this->assertEquals(get_class($user), get_class($authKey->model));
		$this->assertEquals($user->id, $authKey->model_id);
	}

	public function assertAuthRedirects($link, $redirect) {
		preg_match_all('#/auth/key/([^/]+)\?url=(.+)$#', $link, $matches);
		$key = $matches[1][0];
		$url = $matches[2][0];

		$this->assertEquals($redirect, rawurldecode($url));
	}
}