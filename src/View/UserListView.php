<?php

class UserListView {
    public function render($users) {
        echo "<h1>User List</h1>";
        echo "<ul>";
        foreach ($users as $user) {
            // Displaying user ID and name. Avoid displaying passwords for security reasons.
            echo "<li>ID: " . htmlspecialchars($user['id']) . " - Name: " . htmlspecialchars($user['name']) . "</li>";
        }
        echo "</ul>";
    }
}
