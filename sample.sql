CREATE TABLE php_delete.comments (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    comment VARCHAR(255),   
    comment_old VARCHAR(255),
    delete_flag INT(11),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP     
);
alter table comments drop column comment_old;

alter table comments drop column comment;

CREATE TABLE php_delete.log (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    comment VARCHAR(255),   
    comment_id INT(11),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP     
);

alter table log add column statue VARCHAR(255);
alter table log add column comment_old VARCHAR(255);