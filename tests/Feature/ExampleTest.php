<?php

it('[Front] Home page', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
