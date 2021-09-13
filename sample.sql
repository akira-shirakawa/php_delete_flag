CREATE TABLE php_delete.comments (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    comment VARCHAR(255),   
    comment_old VARCHAR(255),
    delete_flag INT(11),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP     
);