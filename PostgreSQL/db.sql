
    comment_id INTEGER,
    answer_id INTEGER,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_polloption_id FOREIGN KEY(poll_option_id) REFERENCES poll_options(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CHECK (
        poll_option_id IS NOT NULL
        OR event_id IS NOT NULL
        OR comment_id IS NOT NULL
        OR answer_id IS NOT NULL
    )
);
CREATE TABLE reports (
    id SERIAL PRIMARY KEY,
    user_id INTEGER DEFAULT 1,
    event_id INTEGER NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) references events(id) ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE bans (
    id SERIAL PRIMARY KEY,
    admin_id INTEGER NOT NULL,
    user_id INTEGER DEFAULT 1,
    reason TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
    expired_at TIMESTAMP,
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE password_resets (
    id SERIAL PRIMARY KEY,
    user_id INTEGER DEFAULT 1,
    token TEXT NOT NULL,
    email TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);
--Functions
CREATE OR REPLACE FUNCTION invites_event_notification_function() RETURNS TRIGGER AS $BODY$ BEGIN
INSERT INTO notifications(user_id, content)
VALUES (New.user_id, 'Invited to event');
INSERT INTO invite_notifications(user_id, notification_id, invite_id)
VALUES (
        New.user_id,
        (
            select currval(pg_get_serial_sequence('notifications', 'id'))
        ),
        New.id
    );
RETURN NEW;
END;
$BODY$ LANGUAGE 'plpgsql';
CREATE OR REPLACE FUNCTION comments_event_notification_function() RETURNS TRIGGER AS $BODY$ BEGIN
INSERT INTO notifications(user_id, content)
VALUES (New.user_id, 'New comment on event');
INSERT INTO comment_notifications(user_id, notification_id, comment_id)
VALUES (
        New.user_id,
        (
            select currval(pg_get_serial_sequence('notifications', 'id'))
        ),
        New.id
    );
RETURN NEW;
END;
$BODY$ LANGUAGE 'plpgsql';
CREATE OR REPLACE FUNCTION create_account() RETURNS TRIGGER AS $BODY$ BEGIN
INSERT INTO users(account_id)
VALUES (NEW.id);
INSERT INTO profile_images(user_id)
VALUES (NEW.id);
RETURN NEW;
END $BODY$ LANGUAGE plpgsql;
CREATE OR REPLACE FUNCTION create_event() RETURNS TRIGGER AS $BODY$ BEGIN
INSERT INTO cover_images(event_id)
VALUES (NEW.id);
RETURN NEW;
END $BODY$ LANGUAGE plpgsql;
CREATE OR REPLACE FUNCTION check_attendee() RETURNS TRIGGER AS $BODY$ BEGIN IF (
        SELECT COUNT(*)
        FROM tickets
        WHERE user_id = NEW.user_id
            AND event_id = NEW.event_id
    ) = 0
    AND (
        SELECT COUNT(*)
        FROM events
        WHERE user_id = NEW.user_id
            AND id = NEW.event_id
    ) = 0 THEN RAISE EXCEPTION 'User is not an attendee of the event';
END IF;
RETURN NEW;
END $BODY$ LANGUAGE plpgsql;
CREATE OR REPLACE FUNCTION delete_user() RETURNS TRIGGER AS $BODY$ BEGIN
UPDATE comments
SET user_id = 1
WHERE user_id = OLD.id;
UPDATE events
SET user_id = 1
WHERE user_id = OLD.id;
UPDATE answers
SET user_id = 1
WHERE user_id = OLD.id;
UPDATE votes
SET user_id = 1
WHERE user_id = OLD.id;
RETURN OLD;
END $BODY$ LANGUAGE plpgsql;
--Triggers
Drop TRIGGER IF EXISTS check_attendee ON tickets;
Drop TRIGGER IF EXISTS create_account ON accounts;
Drop TRIGGER IF EXISTS delete_user ON users;
Drop TRIGGER IF EXISTS create_event ON events;
Drop TRIGGER IF EXISTS invites_event_notification ON invites;
Drop TRIGGER IF EXISTS comments_event_notification ON comments;
-- Trigger 1
CREATE TRIGGER check_attendee BEFORE
INSERT ON comments FOR EACH ROW EXECUTE PROCEDURE check_attendee();
-- Trigger 2
CREATE TRIGGER create_account
AFTER
INSERT ON accounts FOR EACH ROW EXECUTE PROCEDURE create_account();
-- Trigger 3
CREATE TRIGGER delete_user BEFORE DELETE ON users FOR EACH ROW EXECUTE PROCEDURE delete_user();
-- Trigger 4
CREATE TRIGGER create_event
AFTER
INSERT ON events FOR EACH ROW EXECUTE PROCEDURE create_event();
-- Trigger 5
CREATE TRIGGER invites_event_notification_trigger
AFTER
INSERT ON invites FOR EACH ROW EXECUTE PROCEDURE invites_event_notification_function();
-- Trigger 6
CREATE TRIGGER comments_event_notification_trigger
AFTER
INSERT ON comments FOR EACH ROW EXECUTE PROCEDURE comments_event_notification_function();
--Indexes
Drop INDEX IF EXISTS event_name;
Drop INDEX IF EXISTS user_name;
Drop INDEX IF EXISTS event_date;
Drop INDEX IF EXISTS search_event;
Drop INDEX IF EXISTS search_users;
Drop INDEX IF EXISTS search_comment;
--Index 1
CREATE INDEX event_name ON events USING btree (name);
--Index 2
CREATE INDEX account_name ON accounts USING btree (name);
-- Index 3
CREATE INDEX event_date ON events USING btree (start_date);
-- Index 11
do $$ begin IF NOT EXISTS(
    SELECT NULL
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE table_name = 'events'
        AND table_schema = 'lbaw2224'
        AND column_name = 'search'
) THEN
ALTER TABLE events
ADD search TSVECTOR;
END IF;
END $$ LANGUAGE plpgsql;
-- Index 12
do $$ begin IF NOT EXISTS(
    SELECT NULL
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE table_name = 'tags'
        AND table_schema = 'lbaw2224'
        AND column_name = 'search'
) THEN
ALTER TABLE tags
ADD search TSVECTOR;
END IF;
END $$ LANGUAGE plpgsql;
CREATE OR REPLACE FUNCTION event_search_update() RETURNS TRIGGER AS $$ BEGIN IF TG_OP = 'INSERT' THEN NEW.search = (
        setweight(to_tsvector('english', NEW.name), 'A') || setweight(to_tsvector('english', NEW.description), 'B') || setweight(to_tsvector('english', NEW.location), 'C')
    );
END IF;
IF TG_OP = 'UPDATE' THEN IF (
    NEW.name <> OLD.name
    OR NEW.description <> OLD.description
    OR NEW.location <> OLD.location
) THEN NEW.search = (
    setweight(to_tsvector('english', NEW.name), 'A') || setweight(to_tsvector('english', NEW.description), 'B') || setweight(to_tsvector('english', NEW.location), 'C')
);
END IF;
END IF;
RETURN NEW;
END $$ LANGUAGE plpgsql;
CREATE OR REPLACE FUNCTION tag_search_update() RETURNS TRIGGER AS $$ BEGIN IF TG_OP = 'INSERT' THEN NEW.search = (
        setweight(to_tsvector('english', NEW.name), 'A')
    );
END IF;
IF TG_OP = 'UPDATE' THEN IF (NEW.name <> OLD.name) THEN NEW.search = (
    setweight(to_tsvector('english', NEW.name), 'A')
);
END IF;
END IF;
RETURN NEW;
END $$ LANGUAGE plpgsql;
CREATE TRIGGER event_search_update BEFORE
INSERT
    OR
UPDATE ON events FOR EACH ROW EXECUTE PROCEDURE event_search_update();
CREATE TRIGGER event_tag_search_update BEFORE
INSERT
    OR
UPDATE ON tags FOR EACH ROW EXECUTE PROCEDURE tag_search_update();