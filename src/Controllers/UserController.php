<?php

namespace App\Controllers;

class UserController
{
    public function index()
    {
        echo "User List";
    }

    public function show($id)
    {
        // Simulate fetching user
        echo "<h1>User Profile</h1>";
        echo "<p>User ID: " . htmlspecialchars($id) . "</p>";
    }
    
    public function storedPost($postId, $commentId)
    {
        echo "<h1>Post Detail</h1>";
        echo "<p>Post ID: " . htmlspecialchars($postId) . "</p>";
        echo "<p>Comment ID: " . htmlspecialchars($commentId) . "</p>";
    }
}
