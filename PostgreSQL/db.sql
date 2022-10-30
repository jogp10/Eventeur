drop table if exists ACCOUNT CASCADE;
drop table if exists CoverImage CASCADE;
drop table if exists PerfilImage CASCADE;
drop table if exists _USER CASCADE;
drop table if exists ADMINISTRATOR CASCADE;
drop table if exists MANAGER CASCADE;
drop table if exists EVENTS CASCADE;
drop table if exists TAG CASCADE;
drop table if exists EventTag CASCADE;
drop table if exists TICKET CASCADE;
drop table if exists UserTicketEvent CASCADE;
drop table if exists INVITE CASCADE;
drop table if exists NOTIFICATIONS CASCADE;
drop table if exists InviteNotification CASCADE;
drop table if exists COMMENT CASCADE;
drop table if exists CommentNotification CASCADE;
drop table if exists ANSWER CASCADE;
drop table if exists POLL CASCADE;
drop table if exists PollOption CASCADE;
drop table if exists VOTE CASCADE;
drop table if exists REPORT CASCADE;

DROP TYPE IF EXISTS privacy CASCADE;

-- Types

CREATE TYPE privacy as ENUM (
    'Private',
    'Public'
);


-- Tables


CREATE TABLE ACCOUNT (
    id          INTEGER PRIMARY KEY,
    email       TEXT NOT NULL,
    name        TEXT NOT NULL,
    password    TEXT NOT NULL,
    description TEXT,
    age         INTEGER CHECK (age > 0),
    UNIQUE(email)
);

CREATE TABLE EVENTS (
    id SERIAL PRIMARY KEY,
    name        TEXT NOT NULL,
    description TEXT,
    start_date  DATE NOT NULL,
    end_date    DATE NOT NULL,
    location    TEXT NOT NULL,
    capacity    INTEGER NOT NULL,
    privacy     privacy DEFAULT 'Public', 
    CHECK (start_date < end_date),
    CHECK (capacity > 0)
);

CREATE TABLE CoverImage (
    id SERIAL PRIMARY KEY,
    events_id   INTEGER NOT NULL,
    path        TEXT NOT NULL,
    CONSTRAINT fk_events_id FOREIGN KEY(events_id) REFERENCES EVENTS(id),
    UNIQUE(events_id)
);

CREATE TABLE PerfilImage (
    id SERIAL PRIMARY KEY,
    account_id  INTEGER DEFAULT -1,
    path        TEXT NOT NULL,
    CONSTRAINT fk_account_id FOREIGN KEY(account_id) REFERENCES ACCOUNT(id),
    UNIQUE(account_id)
);

CREATE TABLE _USER (--f
    id SERIAL PRIMARY KEY,
    account_id  INTEGER DEFAULT -1,
    CONSTRAINT fk_account_id  FOREIGN KEY(account_id) REFERENCES ACCOUNT(id)
);

CREATE TABLE ADMINISTRATOR (--f
    id SERIAL PRIMARY KEY,
    account_id  INTEGER DEFAULT -1,
    CONSTRAINT fk_account_id  FOREIGN KEY(account_id) REFERENCES ACCOUNT(id)
);

CREATE TABLE MANAGER (
    id SERIAL PRIMARY KEY,
    account_id  INTEGER DEFAULT -1,
    event_id    INTEGER NOT NULL,
    CONSTRAINT fk_account_id  FOREIGN KEY(account_id) REFERENCES ACCOUNT(id),
    CONSTRAINT fk_event_id  FOREIGN KEY(event_id) REFERENCES EVENTS(id),
    UNIQUE(account_id, event_id)
);



CREATE TABLE TAG (--f
    id          SERIAL PRIMARY KEY,
    name        TEXT NOT NULL,
    UNIQUE(name)
);

CREATE TABLE EventTag (--f
    id          SERIAL PRIMARY KEY,
    event_id    INTEGER NOT NULL,
    tag_id      INTEGER NOT NULL,
    CONSTRAINT fk_event_id  FOREIGN KEY(event_id) REFERENCES EVENTS(id),
    CONSTRAINT fk_tag_id  FOREIGN KEY(tag_id) REFERENCES TAG(id),
    UNIQUE(event_id, tag_id)
);

CREATE TABLE TICKET (
    id          SERIAL PRIMARY KEY,
    price       REAL DEFAULT 0
);

CREATE TABLE UserTicketEvent (
    id          SERIAL PRIMARY KEY,
    user_id     INTEGER DEFAULT -1,
    event_id    INTEGER NOT NULL,
    ticket_id   INTEGER NOT NULL,
    num_tickets INTEGER CHECK (num_tickets > 0),
    CONSTRAINT fk_user_id  FOREIGN KEY(user_id) REFERENCES _USER(id),
    CONSTRAINT fk_event_id  FOREIGN KEY(event_id) REFERENCES EVENTS(id),
    CONSTRAINT fk_ticket_id  FOREIGN KEY(ticket_id) REFERENCES TICKET(id),
    UNIQUE(user_id, event_id, ticket_id)
);

CREATE TABLE INVITE (
    id          SERIAL PRIMARY KEY,
    user_id     INTEGER DEFAULT -1,
    event_id    INTEGER NOT NULL,
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES _USER(id),
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) REFERENCES EVENTS(id),
    UNIQUE(user_id, event_id)
);

CREATE TABLE NOTIFICATIONS (
    id          SERIAL PRIMARY KEY,
    user_id     INTEGER DEFAULT -1,
    event_id    INTEGER NOT NULL,
    content     TEXT,
    seen        BOOLEAN DEFAULT '0',
    sent_date        DATE NOT NULL,
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES _USER(id),
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) REFERENCES EVENTS(id)
);

CREATE TABLE InviteNotification (
    id              SERIAL PRIMARY KEY,
    notification_id INTEGER NOT NULL,
    invite_id       INTEGER NOT NULL,
    user_id         INTEGER DEFAULT -1,
    CONSTRAINT fk_notification_id FOREIGN KEY(notification_id) REFERENCES NOTIFICATIONS(id),
    CONSTRAINT fk_invite_id FOREIGN KEY(invite_id) REFERENCES INVITE(id),
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES _USER(id),
    UNIQUE(notification_id, invite_id, user_id)
);

CREATE TABLE COMMENT (
    id              SERIAL PRIMARY KEY,
    user_id         INTEGER DEFAULT -1,
    event_id        INTEGER NOT NULL,
    content         TEXT NOT NULL,
    written_date    DATE NOT NULL CHECK (written_date <= CURRENT_DATE),
    edited          BOOLEAN DEFAULT '0',
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES _USER(id),
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) REFERENCES EVENTS(id)
);

CREATE TABLE CommentNotification (
    id              SERIAL PRIMARY KEY,
    notification_id INTEGER NOT NULL,
    comment_id      INTEGER NOT NULL,
    user_id         INTEGER DEFAULT -1,
    CONSTRAINT fk_notification_id FOREIGN KEY(notification_id) REFERENCES NOTIFICATIONS(id),
    CONSTRAINT fk_comment_id FOREIGN KEY(comment_id) REFERENCES COMMENT(id),
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES _USER(id),
    UNIQUE(notification_id, comment_id, user_id)
);

CREATE TABLE ANSWER (
    id              SERIAL PRIMARY KEY,
    comment_id      INTEGER NOT NULL,
    answer_id       INTEGER NOT NULL,
    CONSTRAINT fk_comment_id FOREIGN KEY(comment_id) REFERENCES COMMENT(id),
    CONSTRAINT fk_answer_id FOREIGN KEY(answer_id) REFERENCES COMMENT(id),
    UNIQUE(answer_id)
);

CREATE TABLE POLL (
    id              SERIAL PRIMARY KEY,
    event_id        INTEGER NOT NULL,
    question        TEXT NOT NULL,
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) REFERENCES EVENTS(id)
);

CREATE TABLE PollOption (
    id              SERIAL PRIMARY KEY,
    poll_id         INTEGER NOT NULL,
    description     TEXT NOT NULL,
    votes           INTEGER DEFAULT 0,
    CONSTRAINT fk_poll_id FOREIGN KEY(poll_id) REFERENCES POLL(id),
    UNIQUE(id, poll_id)
);

CREATE TABLE VOTE (
    id              SERIAL PRIMARY KEY,
    user_id         INTEGER DEFAULT -1,
    poll_option_id  INTEGER NOT NULL,
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES _USER(id),
    CONSTRAINT fk_polloption_id FOREIGN KEY(poll_option_id) REFERENCES PollOption(id),
    UNIQUE(user_id)
);

CREATE TABLE REPORT (
    id              SERIAL PRIMARY KEY,
    user_id         INTEGER DEFAULT -1,
    event_id        INTEGER NOT NULL,
    content         TEXT NOT NULL,
    written_date    DATE NOT NULL CHECK (written_date <= CURRENT_DATE),
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES _USER(id),
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) REFERENCES EVENTS(id)
);

--Functions

CREATE OR REPLACE FUNCTION
    invite_event_notification_function() RETURNS TRIGGER AS $invite_event$
    BEGIN
    	INSERT INTO notifications(user_id, event_id, content, sent_date)
    	VALUES (NEW.user_id, NEW.event_id, 'Invited to Event', NOW()) RETURNING notif_id ;
    	
    	INSERT INTO invitenotification(notification_id, invite_id, user_id)
    	VALUES (notif_id, New.id, New.user_id);

        RETURN NEW;
    END;
$invite_event$ LANGUAGE 'plpgsql';


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
                FROM userticketevent
                WHERE event_id = OLD.id
                UNION
                SELECT account_id
                FROM managers
                WHERE event_id = OLD.id
            ) AS users
        LOOP
            INSERT INTO notifications(content, user_id, event_id, sent_date)
            VALUES ('EventCancellation', u.user_id, OLD.id, NOW());
        END LOOP;

        RETURN OLD;
    END;
$cancel_event$ LANGUAGE 'plpgsql';

CREATE OR REPLACE FUNCTION create_invite_notification() RETURNS TRIGGER AS $BODY$
   	BEGIN
    	WITH inserted AS (
			INSERT into Notifications (content, user_id, event_id, seen, sent_date) values ('You recied an invite...', NEW.user_id, NEW.event_id, '0', CURRENT_DATE)
			RETURNING id
		)
		INSERT into InviteNotification SELECT inserted.id, NEW.id, NEW.user_id FROM inserted;
		RETURN NEW;
   	END;
$BODY$ LANGUAGE plpgsql;


CREATE FUNCTION delete_comment() RETURNS TRIGGER AS
$BODY$
BEGIN 
    DELETE FROM content WHERE content.id = OLD.content_id;
    RETURN OLD;
END
$BODY$
LANGUAGE plpgsql;

CREATE FUNCTION check_attendee() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF (SELECT COUNT(*) FROM userticketevent WHERE user_id = NEW.user_id AND event_id = NEW.event_id) = 0 THEN
        RAISE EXCEPTION 'User is not an attendee of the event';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE FUNCTION delete_user() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE comment SET user_id = 1 WHERE user_id = OLD.id;
    UPDATE userticketevent SET user_id = 1 WHERE user_id = OLD.id;
    UPDATE invite SET user_id = 1 WHERE user_id = OLD.id;
    UPDATE managers SET account_id = 1 WHERE account_id = OLD.id;
    UPDATE events SET creator_id = 1 WHERE creator_id = OLD.id;
    UPDATE notifications SET user_id = 1 WHERE user_id = OLD.id;
    UPDATE content SET user_id = 1 WHERE user_id = OLD.id;
    RETURN OLD;
END
$BODY$
LANGUAGE plpgsql;

--Triggers
Drop TRIGGER IF EXISTS delete_comment ON Comment;
Drop TRIGGER IF EXISTS cancel_event_notification ON Events;
Drop TRIGGER IF EXISTS invite_event_notification ON Invite;
Drop TRIGGER IF EXISTS check_attendee ON userticketevent;
Drop TRIGGER IF EXISTS delete_user ON _user;

-- Trigger 1
CREATE TRIGGER invite_event_notification_trigger 
    AFTER INSERT ON invite
    FOR EACH ROW 
    EXECUTE PROCEDURE invite_event_notification_function();

-- Trigger 2
CREATE TRIGGER cancel_event_notification_trigger 
    AFTER DELETE ON events
    FOR EACH ROW 
    EXECUTE PROCEDURE cancel_event_notification_function();

-- Trigger 3
CREATE TRIGGER delete_comment
    AFTER DELETE ON comment
    FOR EACH ROW
    EXECUTE PROCEDURE delete_comment();

-- Trigger 4
CREATE TRIGGER check_attendee
    BEFORE INSERT ON comment
    FOR EACH ROW
    EXECUTE PROCEDURE check_attendee();

-- Trigger 5
CREATE TRIGGER delete_user
    AFTER DELETE ON _user
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
CREATE INDEX user_name ON user USING btree (name);

-- Index 3
CREATE INDEX event_date ON events USING btree (start_date);

-- Index 11
ALTER TABLE events
ADD COLUMN searchs TSVECTOR;

CREATE FUNCTION event_search_update() RETURNS TRIGGER AS $$
BEGIN
 IF TG_OP = 'INSERT' THEN
        NEW.search = (
         setweight(to_tsvector('english', NEW.name), 'A') ||
         setweight(to_tsvector('english', NEW.description), 'B') ||
         setweight(to_tsvector('english', NEW.location), 'C')
        );
 END IF;
 IF TG_OP = 'UPDATE' THEN
         IF (NEW.title <> OLD.title OR NEW.obs <> OLD.obs OR NEW.location <> OLD.location) THEN
           NEW.tsvectors = (
             setweight(to_tsvector('english', NEW.title), 'A') ||
             setweight(to_tsvector('english', NEW.obs), 'B') ||
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

 CREATE INDEX search_event ON events USING GIN (searchs);

--Index 12
CREATE INDEX search_users ON user USING GIN (search);

--Index 13
CREATE INDEX search_comment ON comment USING GIN (search);

-- Transactions

-- Transaction 1
BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;

Create Poll
INSERT INTO poll (event_id, question)
 VALUES ($event_id, $question);
 
Create at least two options
INSERT INTO polloption (poll_id, description)
 VALUES (currval('poll_id_seq'), $description1);
 
INSERT INTO polloption (poll_id, description)
 VALUES (currval('poll_id_seq'), $description2);

END TRANSACTION;