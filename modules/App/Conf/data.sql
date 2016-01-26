-- ignaszak/cms
-- https://github.com/ignaszak/cms

USE `@dbName@`;

INSERT INTO `@dbName@`.`users`
    (`id`, `login`, `email`, `password`, `reg_date`, `log_date`, `role`)
VALUES
    (1,'@login@','@email@','@hashPassword@','@regDate@','@logDate@','@role@');



INSERT INTO `@dbName@`.`options`
    (`id`, `site_title`, `admin_email`, `view_limit`, `date_format`, `base_url`, `request_uri`, `theme`)
VALUES
    (1,'@siteName@','@email@',10,'d.m.Y H:i','@siteAdress@','@rewriteBase@','Default');



INSERT INTO `@dbName@`.`categories`
    (`id`, `parent_id`, `title`, `alias`)
VALUES
    (1,0,'Home','home');
