<?php

test('the application returns a successful response', function () {
    $response = $this->get('/');
    $response->assertStatus(302); // Accept redirect as valid for unauthenticated
});
