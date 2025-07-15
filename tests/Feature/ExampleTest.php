<?php

test('the application returns a redirect to login', function () {
    $response = $this->get('/');
    $response->assertStatus(302);
    $response->assertRedirect('/login');
});
