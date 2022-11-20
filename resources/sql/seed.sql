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
    CONSTRAINT fk_accounts_id  FOREIGN KEY(account_id) REFERENCES accounts(id)
);

CREATE TABLE admins (
    id         SERIAL PRIMARY KEY,
    account_id  INTEGER DEFAULT -1,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_account_id  FOREIGN KEY(account_id) REFERENCES accounts(id)
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
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) REFERENCES events(id),
    UNIQUE(event_id)
);

CREATE TABLE profile_images (
    id SERIAL PRIMARY KEY,
    account_id  INTEGER DEFAULT -1,
    path        TEXT NOT NULL,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_account_id FOREIGN KEY(account_id) REFERENCES accounts(id),
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
    CONSTRAINT fk_event_id  FOREIGN KEY(event_id) REFERENCES events(id),
    CONSTRAINT fk_tag_id  FOREIGN KEY(tag_id) REFERENCES tags(id),
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
    CONSTRAINT fk_event_id  FOREIGN KEY(event_id) REFERENCES events(id),
    CONSTRAINT fk_user_id  FOREIGN KEY(user_id) REFERENCES users(id),
    UNIQUE(event_id, user_id)
);

CREATE TABLE invites (
    id          SERIAL PRIMARY KEY,
    user_id     INTEGER DEFAULT -1,
    event_id    INTEGER NOT NULL,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) REFERENCES events(id),
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
    CONSTRAINT fk_notification_id FOREIGN KEY(notification_id) REFERENCES notifications(id),
    CONSTRAINT fk_invite_id FOREIGN KEY(invite_id) REFERENCES invites(id),
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
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) REFERENCES events(id)
);

CREATE TABLE comment_notifications (
    id              SERIAL PRIMARY KEY,
    notification_id INTEGER NOT NULL,
    comment_id      INTEGER NOT NULL,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_notification_id FOREIGN KEY(notification_id) REFERENCES notifications(id),
    CONSTRAINT fk_comment_id FOREIGN KEY(comment_id) REFERENCES comments(id),
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
    CONSTRAINT fk_comment_id FOREIGN KEY(comment_id) REFERENCES comments(id)
);

CREATE TABLE polls (
    id              SERIAL PRIMARY KEY,
    event_id        INTEGER NOT NULL,
    question        TEXT NOT NULL,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) REFERENCES events(id)
);

CREATE TABLE poll_options (
    id              SERIAL PRIMARY KEY,
    poll_id         INTEGER NOT NULL,
    description     TEXT NOT NULL,
    votes           INTEGER DEFAULT 0,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_poll_id FOREIGN KEY(poll_id) REFERENCES polls(id),
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
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_polloption_id FOREIGN KEY(poll_option_id) REFERENCES poll_options(id),
    CHECK (poll_option_id IS NOT NULL OR event_id IS NOT NULL OR comment_id IS NOT NULL OR answer_id IS NOT NULL)
);

CREATE TABLE reports (
    id              SERIAL PRIMARY KEY,
    user_id         INTEGER DEFAULT -1,
    event_id        INTEGER NOT NULL,
    content         TEXT NOT NULL,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) REFERENCES events(id)
);

CREATE TABLE bans (
    id              SERIAL PRIMARY KEY,
    admin_id        INTEGER NOT NULL,
    user_id         INTEGER DEFAULT -1,
    ban_type        INTEGER NOT NULL,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES users(id)
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




CREATE OR REPLACE FUNCTION
    cancel_event_notification_function() RETURNS TRIGGER AS $cancel_event$
    DECLARE
        u record;
    BEGIN
        FOR 
            u 
        IN
            SELECT DISTINCT user_id
            FROM (
                SELECT user_id
                FROM tickets
                WHERE event_id = OLD.id
                UNION
                SELECT user_id
                FROM events
                WHERE event_id = OLD.id
            ) AS users
        LOOP
            INSERT INTO notifications(content, user_id, event_id, sent_date)
            VALUES ('eventCancellation', u.user_id, OLD.id, NOW());
        END LOOP;

        RETURN OLD;
    END;
$cancel_event$ LANGUAGE 'plpgsql';

CREATE OR REPLACE FUNCTION delete_comment() RETURNS TRIGGER AS
$BODY$
BEGIN 
    DELETE FROM content WHERE content.id = OLD.content_id;
    RETURN OLD;
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

CREATE OR REPLACE FUNCTION delete_account() RETURNS TRIGGER AS
$BODY$
BEGIN
    DELETE FROM profile_images WHERE profile_images.account_id = OLD.id;
    DELETE FROM users WHERE users.account_id = OLD.id;
    DELETE FROM admins WHERE admins.account_id = OLD.id;
    RETURN OLD;
END
$BODY$
LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION delete_user() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE comments SET user_id = 1 WHERE user_id = OLD.id;
    UPDATE answers SET user_id = 1 WHERE user_id = OLD.id;
    UPDATE votes SET user_id = 1 WHERE user_id = OLD.id;
    UPDATE invites SET user_id = 1 WHERE user_id = OLD.id;
    UPDATE events SET user_id = 1 WHERE user_id = OLD.id;
    UPDATE tickets SET user_id = 1 WHERE user_id = OLD.id;
    UPDATE reports SET user_id = 1 WHERE user_id = OLD.id;
    UPDATE bans SET user_id = 1 WHERE user_id = OLD.id;
    RETURN OLD;
END
$BODY$
LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION create_user() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO users(account_id) VALUES (NEW.id);
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

--Triggers
Drop TRIGGER IF EXISTS delete_comment ON comments;
Drop TRIGGER IF EXISTS cancel_event_notification ON events;
Drop TRIGGER IF EXISTS invites_event_notification ON invites;
Drop TRIGGER IF EXISTS check_attendee ON tickets;

Drop TRIGGER IF EXISTS delete_account ON accounts;
Drop TRIGGER IF EXISTS delete_user ON users;
Drop TRIGGER IF EXISTS create_account ON account;

-- Trigger 1
CREATE TRIGGER invites_event_notification_trigger 
    AFTER INSERT ON invites
    FOR EACH ROW 
    EXECUTE PROCEDURE invites_event_notification_function();

-- Trigger 2
CREATE TRIGGER cancel_event_notification_trigger 
    AFTER DELETE ON events
    FOR EACH ROW 
    EXECUTE PROCEDURE cancel_event_notification_function();

-- Trigger 3
CREATE TRIGGER delete_comment
    AFTER DELETE ON comments
    FOR EACH ROW
    EXECUTE PROCEDURE delete_comment();

-- Trigger 4
CREATE TRIGGER check_attendee
    BEFORE INSERT ON comments
    FOR EACH ROW
    EXECUTE PROCEDURE check_attendee();

-- Trigger 5
CREATE TRIGGER delete_account
    BEFORE DELETE ON accounts
    FOR EACH ROW
    EXECUTE PROCEDURE delete_account();

-- Trigger 6
CREATE TRIGGER delete_user
    BEFORE DELETE ON users
    FOR EACH ROW
    EXECUTE PROCEDURE delete_user();

-- Trigger 7
CREATE TRIGGER create_account
    AFTER INSERT ON accounts
    FOR EACH ROW
    EXECUTE PROCEDURE create_user();

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


-- Populate

INSERT INTO accounts (email, name, password, description, age)
VALUES
  ('anonymous@anonymous.com','deleted account','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','deleted account',999),
  ('ante.ipsum@icloud.org','Tobias Rodriquez','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','enim diam vel arcu. Curabitur ut odio vel est tempor bibendum. Donec felis orci, adipiscing',18),
  ('purus.ac@aol.org','Clark Franklin','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','nascetur ridiculus mus. Aenean eget magna. Suspendisse tristique neque venenatis lacus. Etiam bibendum fermentum metus. Aenean sed pede nec ante',53),
  ('iaculis.lacus@outlook.couk','Inez Hopper','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','Cras sed leo. Cras vehicula aliquet libero. Integer in magna. Phasellus dolor elit, pellentesque a, facilisis non, bibendum sed,',54),
  ('egestas@yahoo.ca','Lani Herrera','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','rhoncus id, mollis nec, cursus a, enim. Suspendisse aliquet, sem ut cursus luctus, ipsum',61),
  ('in.tempus.eu@outlook.edu','Wade Hayden','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','lacus pede sagittis augue, eu tempor erat neque non quam. Pellentesque habitant morbi tristique',55),
  ('venenatis.a.magna@protonmail.org','Omar Bennett','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','tellus sem mollis dui, in sodales elit erat vitae risus. Duis a mi fringilla mi lacinia mattis. Integer eu lacus.',22),
  ('urna.nec@hotmail.net','Adele Mullen','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','mauris ut mi. Duis risus odio, auctor vitae, aliquet nec, imperdiet nec,',25),
  ('magna.et@yahoo.net','Madonna Norris','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','neque. Nullam ut nisi a odio semper cursus. Integer mollis. Integer tincidunt aliquam arcu. Aliquam ultrices',22),
  ('vitae.sodales@google.org','Fay Frye','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','aliquam iaculis, lacus pede sagittis augue, eu tempor erat neque',44),
  ('ipsum@hotmail.ca','Vernon Molina','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','Aliquam ultrices iaculis odio. Nam interdum enim non nisi. Aenean eget metus. In nec orci. Donec nibh. Quisque nonummy ipsum',48),
  ('consequat.lectus@aol.edu','Dacey Christian','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','urna et arcu imperdiet ullamcorper. Duis at lacus. Quisque purus sapien, gravida',63),
  ('integer.mollis.integer@outlook.org','Aspen Giles','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','dictum. Proin eget odio. Aliquam vulputate ullamcorper magna. Sed eu eros. Nam consequat dolor vitae dolor. Donec fringilla. Donec',50),
  ('lobortis.nisi@yahoo.net','Cherokee Kinney','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','Donec sollicitudin adipiscing ligula. Aenean gravida nunc sed pede. Cum sociis natoque penatibus',57),
  ('dolor.fusce@protonmail.couk','Knox Brock','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','odio, auctor vitae, aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non, vestibulum nec, euismod',59),
  ('dictum@google.net','Mara Farrell','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','neque. Sed eget lacus. Mauris non dui nec urna suscipit nonummy. Fusce fermentum fermentum arcu. Vestibulum ante ipsum',56),
  ('dictum.proin@outlook.ca','Macy Dorsey','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','Donec egestas. Aliquam nec enim. Nunc ut erat. Sed nunc est, mollis non, cursus non,',29),
  ('cras.eget.nisi@icloud.net','Kareem Walton','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','nisl sem, consequat nec, mollis vitae, posuere at, velit. Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue.',54),
  ('quisque@protonmail.edu','Linda Mason','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','erat vel pede blandit congue. In scelerisque scelerisque dui. Suspendisse ac metus vitae',39),
  ('ante@icloud.com','Mason Jennings','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','nunc. In at pede. Cras vulputate velit eu sem. Pellentesque ut ipsum ac mi eleifend egestas.',35),
  ('mauris@outlook.org','Chaney Tillman','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue. Sed molestie. Sed id risus quis',35),
  ('integer.tincidunt.aliquam@aol.edu','Ferris Davenport','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','nibh. Phasellus nulla. Integer vulputate, risus a ultricies adipiscing, enim',37),
  ('lacus.etiam@aol.ca','Palmer Barber','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','consequat enim diam vel arcu. Curabitur ut odio vel est tempor bibendum. Donec felis orci, adipiscing non, luctus sit',44),
  ('nisi.nibh@yahoo.ca','Hammett Wall','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','sed dolor. Fusce mi lorem, vehicula et, rutrum eu, ultrices sit amet, risus.',44),
  ('turpis.nec.mauris@aol.edu','Evan Davidson','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','magna. Sed eu eros. Nam consequat dolor vitae dolor. Donec fringilla. Donec',42),
  ('consequat.purus@aol.couk','Lamar Beck','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','dui. Suspendisse ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla',64),
  ('neque@yahoo.couk','Susan Payne','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','quam dignissim pharetra. Nam ac nulla. In tincidunt congue turpis. In',20),
  ('dapibus.id@yahoo.ca','Fitzgerald Cleveland','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','odio. Nam interdum enim non nisi. Aenean eget metus. In nec orci. Donec',25),
  ('massa.suspendisse.eleifend@yahoo.com','Latifah Beasley','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','in aliquet lobortis, nisi nibh lacinia orci, consectetuer euismod est arcu ac',51),
  ('sem.mollis.dui@google.ca','Quon Romero','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','Mauris magna. Duis dignissim tempor arcu. Vestibulum ut eros non enim commodo hendrerit. Donec porttitor',19),
  ('urna.nullam@yahoo.couk','Gannon Cook','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.',49),
  ('augue.eu@google.couk','Harrison Carroll','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','imperdiet ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin a, malesuada id, erat. Etiam vestibulum massa rutrum',54),
  ('curabitur.consequat@yahoo.net','Myra Moses','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','eget tincidunt dui augue eu tellus. Phasellus elit pede, malesuada vel, venenatis vel, faucibus id,',63),
  ('sem.semper@icloud.net','Kelly Reynolds','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','tellus non magna. Nam ligula elit, pretium et, rutrum non, hendrerit id, ante.',38),
  ('augue.malesuada@google.org','Porter Burns','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','sodales purus, in molestie tortor nibh sit amet orci. Ut sagittis lobortis mauris. Suspendisse aliquet molestie tellus. Aenean',49),
  ('lacinia.orci@outlook.net','Drake Jennings','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','et, lacinia vitae, sodales at, velit. Pellentesque ultricies dignissim lacus. Aliquam rutrum lorem ac risus. Morbi metus. Vivamus',65),
  ('ante.bibendum@yahoo.couk','Yael Gentry','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','metus. Aliquam erat volutpat. Nulla facilisis. Suspendisse commodo tincidunt nibh. Phasellus nulla. Integer vulputate,',48),
  ('lobortis.ultrices@yahoo.org','Echo Brock','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','conubia nostra, per inceptos hymenaeos. Mauris ut quam vel sapien imperdiet',56),
  ('sapien.imperdiet@protonmail.ca','Yuri Wolf','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','et libero. Proin mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor vitae,',60),
  ('cras@outlook.org','Joelle Golden','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','mollis. Phasellus libero mauris, aliquam eu, accumsan sed, facilisis vitae, orci.',63),
  ('quam.elementum.at@google.couk','Quamar Reed','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','egestas. Sed pharetra, felis eget varius ultrices, mauris ipsum porta elit, a feugiat tellus lorem eu metus. In',46),
  ('bibendum.ullamcorper@outlook.net','Boris Conley','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','nunc est, mollis non, cursus non, egestas a, dui. Cras pellentesque. Sed dictum. Proin eget',52),
  ('lobortis.mauris@yahoo.ca','Kirsten Perkins','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','leo elementum sem, vitae aliquam eros turpis non enim. Mauris quis turpis vitae purus gravida sagittis.',58),
  ('iaculis.nec@hotmail.edu','Marshall Lester','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare,',32),
  ('consectetuer@hotmail.ca','Stephanie Berg','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','nulla vulputate dui, nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper',36),
  ('et.magnis.dis@yahoo.org','Connor Bradford','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','quis, pede. Praesent eu dui. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus',55),
  ('suscipit.nonummy.fusce@yahoo.com','Rhonda Harding','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','enim, gravida sit amet, dapibus id, blandit at, nisi. Cum sociis natoque',58),
  ('varius.ultrices@hotmail.couk','Samuel Britt','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','malesuada vel, venenatis vel, faucibus id, libero. Donec consectetuer mauris id sapien.',26),
  ('sollicitudin@icloud.org','Melodie Dunn','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','vitae semper egestas, urna justo faucibus lectus, a sollicitudin orci sem eget massa.',37),
  ('auctor.vitae.aliquet@google.net','Lilah Haley','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','Maecenas libero est, congue a, aliquet vel, vulputate eu, odio. Phasellus at augue id ante dictum cursus. Nunc mauris',40),
  ('urna@hotmail.org','Maya Fuller','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','a sollicitudin orci sem eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero. Integer in magna.',33),
  ('vulputate.nisi@yahoo.org','Vera Duffy','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla',50),
  ('vulputate.posuere.vulputate@icloud.com','Anthony Barnes','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem',21),
  ('sociis.natoque.penatibus@outlook.org','Solomon Flynn','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','non, hendrerit id, ante. Nunc mauris sapien, cursus in, hendrerit consectetuer, cursus et, magna. Praesent interdum ligula eu enim. Etiam',32),
  ('ullamcorper.nisl@google.edu','Amal Hensley','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','ultrices iaculis odio. Nam interdum enim non nisi. Aenean eget metus. In nec orci. Donec nibh. Quisque nonummy',62),
  ('pede.blandit@icloud.couk','Holly Sellers','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','elit fermentum risus, at fringilla purus mauris a nunc. In at pede. Cras vulputate velit eu sem.',21),
  ('non.dui@yahoo.net','Sylvia Melton','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','Nam consequat dolor vitae dolor. Donec fringilla. Donec feugiat metus sit amet ante. Vivamus non lorem',38),
  ('imperdiet.ullamcorper@hotmail.edu','Tamara Stanley','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','elit. Etiam laoreet, libero et tristique pellentesque, tellus sem mollis dui, in sodales elit erat vitae risus.',62),
  ('donec.egestas.aliquam@aol.ca','Genevieve Trevino','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','sem egestas blandit. Nam nulla magna, malesuada vel, convallis in, cursus et,',30),
  ('velit.aliquam@icloud.edu','Todd Murray','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','placerat, augue. Sed molestie. Sed id risus quis diam luctus lobortis. Class aptent taciti sociosqu ad litora',38),
  ('ante.nunc.mauris@hotmail.edu','Iris Cochran','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','in aliquet lobortis, nisi nibh lacinia orci, consectetuer euismod est arcu ac orci. Ut semper pretium neque. Morbi quis',59),
  ('neque.morbi.quis@protonmail.ca','Jacob Chambers','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','fringilla est. Mauris eu turpis. Nulla aliquet. Proin velit. Sed malesuada augue ut lacus. Nulla tincidunt, neque vitae semper egestas,',22),
  ('quam.curabitur.vel@icloud.net','Hilda Hodges','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','a, scelerisque sed, sapien. Nunc pulvinar arcu et pede. Nunc sed',42),
  ('quam.vel@aol.ca','Gary Frazier','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','semper et, lacinia vitae, sodales at, velit. Pellentesque ultricies dignissim lacus.',45),
  ('id.sapien.cras@outlook.edu','Veronica Head','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','nisl arcu iaculis enim, sit amet ornare lectus justo eu arcu. Morbi sit amet',25),
  ('malesuada.vel@aol.edu','Kai Lester','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','dictum mi, ac mattis velit justo nec ante. Maecenas mi felis, adipiscing fringilla,',40),
  ('pede.ultrices@google.com','Raven Stark','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','Integer tincidunt aliquam arcu. Aliquam ultrices iaculis odio. Nam interdum enim non',43),
  ('et.risus@aol.couk','Irene Hickman','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor, dictum eu, placerat eget, venenatis a, magna.',33),
  ('odio@hotmail.edu','Mariam Franco','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','eu tellus eu augue porttitor interdum. Sed auctor odio a purus. Duis',58),
  ('metus@icloud.net','Emmanuel Lindsay','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','elit, dictum eu, eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur dictum. Phasellus in',64),
  ('libero.lacus@outlook.net','Paula Britt','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','blandit enim consequat purus. Maecenas libero est, congue a, aliquet vel, vulputate eu,',63),
  ('ut.nisi@outlook.org','Lionel Guerrero','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','lectus, a sollicitudin orci sem eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero. Integer',64),
  ('mattis@icloud.com','Boris Grant','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','Quisque porttitor eros nec tellus. Nunc lectus pede, ultrices a, auctor non, feugiat nec, diam. Duis mi',35),
  ('non.enim@icloud.org','Harriet Montgomery','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','vel turpis. Aliquam adipiscing lobortis risus. In mi pede, nonummy ut, molestie in, tempus eu, ligula. Aenean euismod mauris',61),
  ('lectus.rutrum@aol.com','Rae Slater','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','venenatis lacus. Etiam bibendum fermentum metus. Aenean sed pede nec ante blandit viverra. Donec tempus,',64),
  ('nunc.ac@icloud.edu','Mira Arnold','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','metus. In lorem. Donec elementum, lorem ut aliquam iaculis, lacus pede',48),
  ('montes@protonmail.ca','Giacomo Booth','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','Duis cursus, diam at pretium aliquet, metus urna convallis erat, eget tincidunt dui augue',32),
  ('ac.tellus@yahoo.com','Berk Ewing','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','Quisque fringilla euismod enim. Etiam gravida molestie arcu. Sed eu nibh vulputate mauris sagittis placerat. Cras',42),
  ('in.sodales@yahoo.ca','Cyrus Gates','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','cursus purus. Nullam scelerisque neque sed sem egestas blandit. Nam nulla magna, malesuada vel, convallis',24),
  ('nulla@icloud.com','Brynn Reynolds','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','lacus. Aliquam rutrum lorem ac risus. Morbi metus. Vivamus euismod urna. Nullam lobortis quam a felis ullamcorper viverra. Maecenas iaculis',64),
  ('mattis.integer@outlook.ca','Eaton Black','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','eleifend non, dapibus rutrum, justo. Praesent luctus. Curabitur egestas nunc sed libero. Proin sed turpis nec mauris',63),
  ('convallis.in@icloud.com','Marshall Mcmillan','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam, elementum at,',58),
  ('metus.eu.erat@protonmail.com','Gillian Montgomery','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','ante, iaculis nec, eleifend non, dapibus rutrum, justo. Praesent luctus. Curabitur egestas nunc sed libero. Proin sed',49),
  ('sed.id@hotmail.ca','Piper Cardenas','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','Donec egestas. Aliquam nec enim. Nunc ut erat. Sed nunc est, mollis non, cursus non,',55),
  ('sagittis.duis@yahoo.net','Troy Cortez','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','lectus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec dignissim magna',20),
  ('sed@protonmail.net','Wesley Espinoza','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','sed dictum eleifend, nunc risus varius orci, in consequat enim diam vel',30),
  ('tincidunt.aliquam@yahoo.org','Grace $2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','SEN83UVG6ZO','at risus. Nunc ac sem ut dolor dapibus gravida. Aliquam tincidunt, nunc ac mattis ornare, lectus ante',21),
  ('velit.justo@icloud.net','Lionel Harding','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','amet, consectetuer adipiscing elit. Aliquam auctor, velit eget laoreet posuere, enim nisl elementum purus, accumsan interdum libero',24),
  ('elit.a@google.org','Brenden Mcfadden','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','Morbi quis urna. Nunc quis arcu vel quam dignissim pharetra. Nam ac nulla. In tincidunt congue turpis.',20),
  ('donec@icloud.org','Jelani Valenzuela','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','aliquam adipiscing lacus. Ut nec urna et arcu imperdiet ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin',38),
  ('volutpat.ornare@aol.edu','Delilah Hurst','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','Etiam bibendum fermentum metus. Aenean sed pede nec ante blandit viverra. Donec tempus, lorem fringilla ornare',59),
  ('nisl.arcu.iaculis@google.org','Edan Hodge','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','ullamcorper magna. Sed eu eros. Nam consequat dolor vitae dolor. Donec fringilla. Donec feugiat',38),
  ('facilisis@protonmail.com','Lilah Sharpe','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','at, velit. Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue.',64),
  ('urna.vivamus@icloud.com','Kylynn Bailey','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','vitae, posuere at, velit. Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue. Sed molestie. Sed id risus',18),
  ('aliquam@yahoo.couk','Michael Gamble','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','Nulla eu neque pellentesque massa lobortis ultrices. Vivamus rhoncus. Donec est. Nunc ullamcorper, velit',54),
  ('sed.nec.metus@outlook.org','Isaiah Munoz','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','imperdiet non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem',48),
  ('pellentesque.massa@yahoo.com','Bruno Kramer','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','Sed nunc est, mollis non, cursus non, egestas a, dui. Cras pellentesque. Sed dictum. Proin eget odio. Aliquam vulputate',56),
  ('sit.amet.metus@outlook.couk','Donna Olsen','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','nunc sed libero. Proin sed turpis nec mauris blandit mattis. Cras eget nisi',62),
  ('felis.donec.tempor@icloud.couk','Nicole Williams','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','a sollicitudin orci sem eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero.',61),
  ('quis.lectus@google.com','Sierra Webb','$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe','nonummy ut, molestie in, tempus eu, ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque. Sed eget lacus. Mauris',25),
  ('johndoe@fe.up.pt', 'John Doe', '$2y$10$1n1Mta/k896NGbgQLIfY1uyYgA3rDOm5Q2xOqoeutmgCuuocdeexe', 'Hey, Im John Doe', 22),
  ('admin1@fe.up.pt', 'admin1', '$2y$10$BSs2Kg/G.r3fE5oPUD/6CObVNX9touzKQFAG24uQXORT5gED.NzAa', 'admin1', 1);


INSERT INTO admins (account_id)
VALUES
  (49),
  (14),
  (86),
  (64),   
  (96),
  (50),
  (48),
  (2),
  (75),
  (51),
  (102);


INSERT INTO events (user_id, name,description,start_date,end_date,location,capacity,privacy)
VALUES
  (45,'eu dolor egestas rhoncus. Proin nisl sem, consequat','In lorem. Donec elementum, lorem ut aliquam iaculis, lacus pede sagittis augue, eu tempor erat neque non quam.','2021-10-25', '2021-11-13','P.O. Box 737, 2366 Diam Av.',417,'Public'),
  (98,'magnis dis parturient montes, nascetur ridiculus','tellus. Aenean egestas hendrerit neque. In ornare sagittis felis. Donec tempor, est ac mattis semper, dui lectus rutrum urna, nec luctus felis purus ac tellus. Suspendisse sed dolor. Fusce mi lorem, vehicula et, rutrum eu, ultrices sit amet,','2021-10-22','2021-11-20','Ap #415-6093 Eget Street',380,'Public'),
  (16,'senectus et netus et','congue. In scelerisque scelerisque dui. Suspendisse ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla vulputate dui, nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id','2021-10-18','2021-11-23','1448 Ac, Av.',204,'Public'),
  (59,'elit sed consequat auctor, nunc','sodales elit erat vitae risus. Duis a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet,','2021-10-21','2021-11-08','883-8470 Magna Av.',58,'Public'),
  (83,'amet, consectetuer adipiscing elit. Etiam laoreet,','Cras vehicula aliquet libero. Integer in magna. Phasellus dolor elit, pellentesque a, facilisis non, bibendum sed, est. Nunc','2021-10-25','2021-11-02','190-3930 Cum St.',204,'Private'),
  (39,'non sapien molestie orci tincidunt adipiscing. Mauris','Cras interdum. Nunc sollicitudin commodo ipsum. Suspendisse non leo. Vivamus nibh dolor, nonummy ac, feugiat non, lobortis quis, pede. Suspendisse dui. Fusce diam nunc, ullamcorper eu, euismod ac, fermentum vel,','2021-05-19','2021-07-11','Ap #812-8492 Cum Road',355,'Public'),
  (79,'Sed malesuada augue ut','lobortis risus. In mi pede, nonummy ut, molestie in, tempus eu, ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque. Sed eget lacus.','2021-10-28','2021-11-13','249-9537 Eget, Avenue',324,'Public'),
  (19,'vehicula aliquet libero. Integer in magna.','consequat, lectus sit amet luctus vulputate, nisi sem semper erat, in consectetuer ipsum nunc id enim. Curabitur massa. Vestibulum accumsan neque et nunc. Quisque ornare','2021-10-21','2021-11-22','757-8707 Mi. Ave',361,'Public'),
  (45,'arcu. Curabitur ut','euismod ac, fermentum vel, mauris. Integer sem elit, pharetra ut, pharetra sed, hendrerit a, arcu. Sed et libero. Proin mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor vitae, aliquet','2021-10-26','2021-11-17','Ap #257-9182 Sapien. Ave',274,'Public'),
  (15,'augue scelerisque mollis.','sit amet ornare lectus justo eu arcu. Morbi sit amet massa. Quisque porttitor eros nec tellus. Nunc lectus pede, ultrices a, auctor non, feugiat nec,','2021-10-23','2021-11-13','246-6797 Pharetra, Road',475,'Private'),
  (71,'dolor. Quisque tincidunt pede ac','metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla vulputate dui, nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae','2021-10-23','2021-11-24','5716 Augue St.',364,'Private'),
  (83,'risus. Donec egestas. Aliquam nec enim.','mollis. Duis sit amet diam eu dolor egestas rhoncus. Proin nisl sem, consequat nec, mollis vitae, posuere at, velit. Cras','2021-10-26','2021-11-06','123-8901 Lacus. Av.',73,'Public'),
  (5,'pede, nonummy ut, molestie','Donec vitae erat vel pede blandit congue. In scelerisque scelerisque dui. Suspendisse ac metus vitae velit egestas lacinia. Sed congue,','2021-10-23','2021-11-18','Ap #886-3769 Ligula Av.',493,'Private'),
  (76,'magna. Suspendisse tristique','et ultrices posuere cubilia Curae Donec tincidunt. Donec vitae erat vel pede blandit congue. In scelerisque scelerisque dui. Suspendisse ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc','2021-10-24','2021-11-19','P.O. Box 132, 259 Lorem Street',474,'Public'),
  (88,'viverra. Donec tempus, lorem','at, iaculis quis, pede. Praesent eu dui. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean eget magna. Suspendisse tristique neque venenatis lacus. Etiam bibendum fermentum metus.','2021-10-30','2021-11-04','575-1718 Orci Ave',89,'Public'),
  (87,'velit justo nec','ante lectus convallis est, vitae sodales nisi magna sed dui. Fusce aliquam, enim nec tempus scelerisque, lorem','2021-10-28','2021-11-19','491-4933 Quis Avenue',59,'Public'),
  (98,'sollicitudin a, malesuada id, erat. Etiam vestibulum','cursus vestibulum. Mauris magna. Duis dignissim tempor arcu. Vestibulum ut eros non enim commodo hendrerit. Donec porttitor tellus non magna. Nam ligula elit, pretium et, rutrum non, hendrerit id, ante. Nunc mauris sapien, cursus in,','2021-10-31','2021-11-15','Ap #103-5435 Aliquam Road',326,'Public'),
  (3,'quis, tristique ac, eleifend vitae,','ipsum porta elit, a feugiat tellus lorem eu metus. In lorem. Donec elementum, lorem ut aliquam iaculis, lacus pede sagittis augue, eu','2021-10-30','2021-11-22','Ap #265-3578 Cum St.',299,'Public'),
  (92,'pede. Cras vulputate velit','ut nisi a odio semper cursus. Integer mollis. Integer tincidunt aliquam arcu. Aliquam ultrices iaculis odio. Nam interdum enim non nisi. Aenean eget metus. In nec orci. Donec nibh. Quisque nonummy ipsum','2021-10-22','2021-11-03','P.O. Box 670, 4409 Neque. Street',86,'Private'),
  (58,'condimentum. Donec at arcu. Vestibulum','faucibus orci luctus et ultrices posuere cubilia Curae Phasellus ornare. Fusce mollis. Duis sit amet diam eu dolor egestas rhoncus. Proin nisl sem, consequat nec, mollis vitae, posuere at, velit. Cras lorem lorem, luctus ut, pellentesque eget, dictum','2021-10-19','2021-11-02','806-7720 Litora Ave',205,'Public');


INSERT INTO tags (name)
VALUES
  ('diam.'),
  ('Nullam'),
  ('Mauris'),
  ('ligula.'),
  ('in,'),
  ('iaculis'),
  ('dui.'),
  ('orci,'),
  ('ac'),
  ('et,'),
  ('sapien,'),
  ('tempor'),
  ('elit'),
  ('Ut'),
  ('egestas.'),
  ('eget'),
  ('In'),
  ('Donec'),
  ('Vivamus'),
  ('urna.');


INSERT INTO event_tag (event_id,tag_id)
VALUES
  (2,3),
  (18,4),
  (5,13),
  (13,4),
  (11,10),
  (10,17),
  (11,15),
  (19,5),
  (17,6),
  (6,7),
  (7,2),
  (8,15),
  (19,16),
  (3,11),
  (14,4),
  (20,11),
  (11,7),
  (9,8),
  (12,12),
  (20,16);

INSERT INTO tickets (user_id, event_id, num_of_tickets)
VALUES
    (3, 1, 5);
	
INSERT INTO comments (user_id, event_id, content)
VALUES
   (3, 1, 'Great job the organizer team has done here!');

INSERT INTO answers (comment_id, user_id, content)
VALUES
   (1, 45, 'Danke!');

INSERT INTO invites (user_id, event_id)
VALUES
   (101, 1);
