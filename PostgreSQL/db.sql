drop table if exists accounts CASCADE;
drop table if exists cover_images CASCADE;
drop table if exists profile_images CASCADE;
drop table if exists users CASCADE;
drop table if exists admins CASCADE;
drop table if exists events CASCADE;
drop table if exists tags CASCADE;
drop table if exists event_tag CASCADE;
drop table if exists tickets CASCADE;
drop table if exists invites CASCADE;
drop table if exists notifications CASCADE;
drop table if exists invite_notifications CASCADE;
drop table if exists comments CASCADE;
drop table if exists comment_notifications CASCADE;
drop table if exists answers CASCADE;
drop table if exists polls CASCADE;
drop table if exists poll_options CASCADE;
drop table if exists votes CASCADE;
drop table if exists reports CASCADE;
drop table if exists bans CASCADE;

DROP TYPE IF EXISTS privacy CASCADE;

-- Types

CREATE TYPE privacy as ENUM (
    'Private',
    'Public'
);


-- Tables


CREATE TABLE accounts (
    id          SERIAL PRIMARY KEY,
    email       TEXT NOT NULL,
    name        TEXT NOT NULL,
    password    TEXT NOT NULL,
    description TEXT,
    age         INTEGER CHECK (age > 0),
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    UNIQUE(email)
);

CREATE TABLE users (
    id          SERIAL PRIMARY KEY,
    account_id  INTEGER DEFAULT -1,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_accounts_id  FOREIGN KEY(account_id) REFERENCES accounts(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE admins (
    id         SERIAL PRIMARY KEY,
    account_id  INTEGER DEFAULT -1,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_account_id  FOREIGN KEY(account_id) REFERENCES accounts(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE events (
    id SERIAL PRIMARY KEY,
    name        TEXT NOT NULL,
    description TEXT NOT NULL,
    start_date  DATE NOT NULL,
    end_date    DATE NOT NULL,
    location    TEXT NOT NULL,
    capacity    INTEGER NOT NULL,
    privacy     privacy DEFAULT 'Public', 
    user_id     INTEGER NOT NULL,
    ticket     INTEGER NOT NULL DEFAULT 0,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES users(id),
    CHECK (start_date < end_date),
    CHECK (capacity > 0)
);

CREATE TABLE cover_images (
    id SERIAL PRIMARY KEY,
    event_id   INTEGER NOT NULL,
    path        TEXT NOT NULL,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) references events(id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE(event_id)
);

CREATE TABLE profile_images (
    id SERIAL PRIMARY KEY,
    account_id  INTEGER DEFAULT -1,
    path        TEXT NOT NULL,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_account_id FOREIGN KEY(account_id) REFERENCES accounts(id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE(account_id)
);

CREATE TABLE tags (
    id          SERIAL PRIMARY KEY,
    name        TEXT NOT NULL,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    UNIQUE(name)
);

CREATE TABLE event_tag (
    id          SERIAL PRIMARY KEY,
    event_id    INTEGER NOT NULL,
    tag_id      INTEGER NOT NULL,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_event_id  FOREIGN KEY(event_id) references events(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_tag_id  FOREIGN KEY(tag_id) REFERENCES tags(id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE(event_id, tag_id)
);

CREATE TABLE tickets (
    id          SERIAL PRIMARY KEY,
    event_id    INTEGER NOT NULL,
    user_id     INTEGER NOT NULL,
    num_of_tickets INTEGER NOT NULL,
    price       REAL DEFAULT 0,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_event_id  FOREIGN KEY(event_id) references events(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_user_id  FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE(event_id, user_id)
);

CREATE TABLE invites (
    id          SERIAL PRIMARY KEY,
    user_id     INTEGER DEFAULT -1,
    event_id    INTEGER NOT NULL,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) references events(id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE(user_id, event_id)
);

CREATE TABLE notifications (
    id          SERIAL PRIMARY KEY,
    content     TEXT,
    seen        BOOLEAN DEFAULT '0',
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW()
);

CREATE TABLE invite_notifications (
    id              SERIAL PRIMARY KEY,
    notification_id INTEGER NOT NULL,
    invite_id       INTEGER NOT NULL,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_notification_id FOREIGN KEY(notification_id) REFERENCES notifications(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_invite_id FOREIGN KEY(invite_id) REFERENCES invites(id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE(notification_id, invite_id)
);

CREATE TABLE comments (
    id              SERIAL PRIMARY KEY,
    user_id         INTEGER DEFAULT -1,
    event_id        INTEGER NOT NULL,
    content         TEXT NOT NULL,
    edited          BOOLEAN DEFAULT '0',
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) references events(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE comment_notifications (
    id              SERIAL PRIMARY KEY,
    notification_id INTEGER NOT NULL,
    comment_id      INTEGER NOT NULL,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_notification_id FOREIGN KEY(notification_id) REFERENCES notifications(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_comment_id FOREIGN KEY(comment_id) REFERENCES comments(id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE(notification_id, comment_id)
);

CREATE TABLE answers (
    id              SERIAL PRIMARY KEY,
    comment_id      INTEGER NOT NULL,
    user_id         INTEGER DEFAULT -1,
    content         TEXT NOT NULL,
    edited          BOOLEAN DEFAULT '0',
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_comment_id FOREIGN KEY(comment_id) REFERENCES comments(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE polls (
    id              SERIAL PRIMARY KEY,
    event_id        INTEGER NOT NULL,
    question        TEXT NOT NULL,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) references events(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE poll_options (
    id              SERIAL PRIMARY KEY,
    poll_id         INTEGER NOT NULL,
    description     TEXT NOT NULL,
    votes           INTEGER DEFAULT 0,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_poll_id FOREIGN KEY(poll_id) REFERENCES polls(id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE(id, poll_id)
);

CREATE TABLE votes (
    id              SERIAL PRIMARY KEY,
    user_id         INTEGER DEFAULT -1,
    poll_option_id  INTEGER,
    event_id        INTEGER,
    comment_id      INTEGER,
    answer_id      INTEGER,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_polloption_id FOREIGN KEY(poll_option_id) REFERENCES poll_options(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CHECK (poll_option_id IS NOT NULL OR event_id IS NOT NULL OR comment_id IS NOT NULL OR answer_id IS NOT NULL)
);

CREATE TABLE reports (
    id              SERIAL PRIMARY KEY,
    user_id         INTEGER DEFAULT -1,
    event_id        INTEGER NOT NULL,
    content         TEXT NOT NULL,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) references events(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE bans (
    id              SERIAL PRIMARY KEY,
    admin_id        INTEGER NOT NULL,
    user_id         INTEGER DEFAULT -1,
    ban_type        INTEGER NOT NULL,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);

--Functions

CREATE OR REPLACE FUNCTION
    invites_event_notification_function() RETURNS TRIGGER AS $BODY$
    BEGIN
    	INSERT INTO notifications(content) VALUES ('Invited to event');

    	INSERT INTO invite_notifications(notification_id, invite_id) VALUES ((select currval(pg_get_serial_sequence('notifications', 'id'))), New.id);

        RETURN NEW;

    END;
$BODY$ LANGUAGE 'plpgsql';

CREATE OR REPLACE FUNCTION create_account() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO users(account_id) VALUES (NEW.id);
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION check_attendee() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF (SELECT COUNT(*) FROM tickets WHERE user_id = NEW.user_id AND event_id = NEW.event_id) = 0 AND (SELECT COUNT(*) FROM events WHERE user_id = NEW.user_id AND id = NEW.event_id) = 0 THEN
        RAISE EXCEPTION 'User is not an attendee of the event';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION delete_user() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE comments SET user_id = 1 WHERE user_id = OLD.id;
    UPDATE events SET user_id = 1 WHERE user_id = OLD.id;
    UPDATE answers SET user_id = 1 WHERE user_id = OLD.id;
    RETURN OLD;
END
$BODY$
LANGUAGE plpgsql;

--Triggers
Drop TRIGGER IF EXISTS invites_event_notification ON invites;
Drop TRIGGER IF EXISTS check_attendee ON tickets;
Drop TRIGGER IF EXISTS create_account ON accounts;
Drop TRIGGER IF EXISTS delete_user ON users;

-- Trigger 1
CREATE TRIGGER invites_event_notification_trigger 
    AFTER INSERT ON invites
    FOR EACH ROW 
    EXECUTE PROCEDURE invites_event_notification_function();

-- Trigger 2
CREATE TRIGGER check_attendee
    BEFORE INSERT ON comments
    FOR EACH ROW
    EXECUTE PROCEDURE check_attendee();

-- Trigger 3
CREATE TRIGGER create_account
    AFTER INSERT ON accounts
    FOR EACH ROW
    EXECUTE PROCEDURE create_account();

-- Trigger 4
CREATE TRIGGER delete_user
    BEFORE DELETE ON users
    FOR EACH ROW
    EXECUTE PROCEDURE delete_user();


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
do $$
begin
IF NOT EXISTS( SELECT NULL
            FROM INFORMATION_SCHEMA.COLUMNS
           WHERE table_name = 'events'
             AND table_schema = 'lbaw2224'
             AND column_name = 'search')  THEN

  ALTER TABLE events ADD search TSVECTOR;

END IF;
END $$
LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION event_search_update() RETURNS TRIGGER AS $$
BEGIN
 IF TG_OP = 'INSERT' THEN
        NEW.search = (
         setweight(to_tsvector('english', NEW.name), 'A') ||
         setweight(to_tsvector('english', NEW.description), 'B') ||
         setweight(to_tsvector('english', NEW.location), 'C')
        );
 END IF;
 IF TG_OP = 'UPDATE' THEN
         IF (NEW.name <> OLD.name OR NEW.description <> OLD.description OR NEW.location <> OLD.location) THEN
           NEW.tsvectors = (
             setweight(to_tsvector('english', NEW.name), 'A') ||
             setweight(to_tsvector('english', NEW.description), 'B') ||
             setweight(to_tsvector('english', NEW.location), 'C')
           );
         END IF;
 END IF;
 RETURN NEW;
END $$
LANGUAGE plpgsql;


CREATE TRIGGER event_search_update
BEFORE INSERT OR UPDATE ON events
FOR EACH ROW
EXECUTE PROCEDURE event_search_update();

--CREATE INDEX search_event ON events USING GIN (searchs);

--Index 12
--CREATE INDEX search_users ON users USING GIN (searchs);

--Index 13
--CREATE INDEX search_comment ON comments USING GIN (searchs);

-- Transactions

-- Transaction 1

/*
BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;

Create polls
INSERT INTO polls (event_id, question)
 VALUES ($event_id, $question);
 
Create at least two options
INSERT INTO poll_options (poll_id, description)
 VALUES (currval('poll_id_seq'), $description1);
 
INSERT INTO poll_options (poll_id, description)
 VALUES (currval('poll_id_seq'), $description2);

END TRANSACTION;*/