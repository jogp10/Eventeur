drop table if exists accounts CASCADE;
drop table if exists cover_images CASCADE;
drop table if exists profile_images CASCADE;
drop table if exists users CASCADE;
drop table if exists admins CASCADE;
drop table if exists events CASCADE;
drop table if exists tags CASCADE;
drop table if exists event_tags CASCADE;
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
    id SERIAL PRIMARY KEY,
    accounts_id  INTEGER DEFAULT -1,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_accounts_id  FOREIGN KEY(accounts_id) REFERENCES accounts(id)
);

CREATE TABLE admins (
    id SERIAL PRIMARY KEY,
    accounts_id  INTEGER DEFAULT -1,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_accounts_id  FOREIGN KEY(accounts_id) REFERENCES accounts(id)
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
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) REFERENCES events(id),
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
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

CREATE TABLE event_tags (
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
    poll_option_id  INTEGER NOT NULL,
    created_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_polloption_id FOREIGN KEY(poll_option_id) REFERENCES poll_options(id),
    UNIQUE(user_id)
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
    invites_event_notification_function() RETURNS TRIGGER AS $invites_event$
    BEGIN
    	INSERT INTO notifications(user_id, event_id, content, sent_date)
    	VALUES (NEW.user_id, NEW.event_id, 'invitesd to event', NOW()) RETURNING notif_id ;
    	
    	INSERT INTO invite_notifications(notification_id, invites_id, user_id)
    	VALUES (notif_id, New.id, New.user_id);

        RETURN NEW;
    END;
$invites_event$ LANGUAGE 'plpgsql';


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

CREATE OR REPLACE FUNCTION create_invites_notification() RETURNS TRIGGER AS $BODY$
   	BEGIN
    	WITH inserted AS (
			INSERT into notifications (content, user_id, event_id, seen, sent_date) values ('You recied an invites...', NEW.user_id, NEW.event_id, '0', CURRENT_DATE)
			RETURNING id
		)
		INSERT into invite_notifications SELECT inserted.id, NEW.id, NEW.user_id FROM inserted;
		RETURN NEW;
   	END;
$BODY$ LANGUAGE plpgsql;


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

CREATE OR REPLACE FUNCTION delete_user() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE comments SET user_id = 1 WHERE user_id = OLD.id;
    UPDATE invites SET user_id = 1 WHERE user_id = OLD.id;
    UPDATE events SET accounts_id = 1 WHERE accounts_id = OLD.id;
    UPDATE notifications SET user_id = 1 WHERE user_id = OLD.id;
    UPDATE content SET user_id = 1 WHERE user_id = OLD.id;
    RETURN OLD;
END
$BODY$
LANGUAGE plpgsql;

--Triggers
Drop TRIGGER IF EXISTS delete_comment ON comments;
Drop TRIGGER IF EXISTS cancel_event_notification ON events;
Drop TRIGGER IF EXISTS invites_event_notification ON invites;
Drop TRIGGER IF EXISTS check_attendee ON tickets;
Drop TRIGGER IF EXISTS delete_user ON users;

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
CREATE TRIGGER delete_user
    AFTER DELETE ON users
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
--CREATE INDEX user_name ON users USING btree (name);

-- Index 3
CREATE INDEX event_date ON events USING btree (start_date);

-- Index 11
ALTER TABLE events
ADD COLUMN searchs TSVECTOR;

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

/*
CREATE TRIGGER event_search_update
 BEFORE INSERT OR UPDATE ON events
 FOR EACH ROW
 EXECUTE PROCEDURE event_search_update();
*/
CREATE INDEX search_event ON events USING GIN (searchs);

--Index 12
--CREATE INDEX search_users ON users USING GIN (search);

--Index 13
--CREATE INDEX search_comment ON comments USING GIN (search);

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
  ('anynomous@anynomous.com','deleted account','MRS20KYI7ST','deleted account',999),
  ('ante.ipsum@icloud.org','Tobias Rodriquez','YEK65KFW7BP','enim diam vel arcu. Curabitur ut odio vel est tempor bibendum. Donec felis orci, adipiscing',18),
  ('purus.ac@aol.org','Clark Franklin','JSZ36EKV3JZ','nascetur ridiculus mus. Aenean eget magna. Suspendisse tristique neque venenatis lacus. Etiam bibendum fermentum metus. Aenean sed pede nec ante',53),
  ('iaculis.lacus@outlook.couk','Inez Hopper','EKI16OVT3BM','Cras sed leo. Cras vehicula aliquet libero. Integer in magna. Phasellus dolor elit, pellentesque a, facilisis non, bibendum sed,',54),
  ('egestas@yahoo.ca','Lani Herrera','SIB97GJS2YR','rhoncus id, mollis nec, cursus a, enim. Suspendisse aliquet, sem ut cursus luctus, ipsum',61),
  ('in.tempus.eu@outlook.edu','Wade Hayden','SOL48VUV5TP','lacus pede sagittis augue, eu tempor erat neque non quam. Pellentesque habitant morbi tristique',55),
  ('venenatis.a.magna@protonmail.org','Omar Bennett','MQT91UYB8VH','tellus sem mollis dui, in sodales elit erat vitae risus. Duis a mi fringilla mi lacinia mattis. Integer eu lacus.',22),
  ('urna.nec@hotmail.net','Adele Mullen','EOP57KON1EQ','mauris ut mi. Duis risus odio, auctor vitae, aliquet nec, imperdiet nec,',25),
  ('magna.et@yahoo.net','Madonna Norris','TYA06JDA1ML','neque. Nullam ut nisi a odio semper cursus. Integer mollis. Integer tincidunt aliquam arcu. Aliquam ultrices',22),
  ('vitae.sodales@google.org','Fay Frye','HSN72HDW2WL','aliquam iaculis, lacus pede sagittis augue, eu tempor erat neque',44),
  ('ipsum@hotmail.ca','Vernon Molina','ESR28LBN4ZI','Aliquam ultrices iaculis odio. Nam interdum enim non nisi. Aenean eget metus. In nec orci. Donec nibh. Quisque nonummy ipsum',48),
  ('consequat.lectus@aol.edu','Dacey Christian','ISV60NYT4UP','urna et arcu imperdiet ullamcorper. Duis at lacus. Quisque purus sapien, gravida',63),
  ('integer.mollis.integer@outlook.org','Aspen Giles','OYQ10OHT7WC','dictum. Proin eget odio. Aliquam vulputate ullamcorper magna. Sed eu eros. Nam consequat dolor vitae dolor. Donec fringilla. Donec',50),
  ('lobortis.nisi@yahoo.net','Cherokee Kinney','MGJ02MEM6BE','Donec sollicitudin adipiscing ligula. Aenean gravida nunc sed pede. Cum sociis natoque penatibus',57),
  ('dolor.fusce@protonmail.couk','Knox Brock','YYT66VNE1BN','odio, auctor vitae, aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non, vestibulum nec, euismod',59),
  ('dictum@google.net','Mara Farrell','OOU59HHV3TN','neque. Sed eget lacus. Mauris non dui nec urna suscipit nonummy. Fusce fermentum fermentum arcu. Vestibulum ante ipsum',56),
  ('dictum.proin@outlook.ca','Macy Dorsey','CLC05VIM3MH','Donec egestas. Aliquam nec enim. Nunc ut erat. Sed nunc est, mollis non, cursus non,',29),
  ('cras.eget.nisi@icloud.net','Kareem Walton','YWO33UMQ2VE','nisl sem, consequat nec, mollis vitae, posuere at, velit. Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue.',54),
  ('quisque@protonmail.edu','Linda Mason','MSP83ZIE3KT','erat vel pede blandit congue. In scelerisque scelerisque dui. Suspendisse ac metus vitae',39),
  ('ante@icloud.com','Mason Jennings','LEB45QFV5VW','nunc. In at pede. Cras vulputate velit eu sem. Pellentesque ut ipsum ac mi eleifend egestas.',35),
  ('mauris@outlook.org','Chaney Tillman','KQX85MQG8PT','Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue. Sed molestie. Sed id risus quis',35),
  ('integer.tincidunt.aliquam@aol.edu','Ferris Davenport','ZWN52EII4KW','nibh. Phasellus nulla. Integer vulputate, risus a ultricies adipiscing, enim',37),
  ('lacus.etiam@aol.ca','Palmer Barber','RNB59DHM0KF','consequat enim diam vel arcu. Curabitur ut odio vel est tempor bibendum. Donec felis orci, adipiscing non, luctus sit',44),
  ('nisi.nibh@yahoo.ca','Hammett Wall','UNM44MFJ1YU','sed dolor. Fusce mi lorem, vehicula et, rutrum eu, ultrices sit amet, risus.',44),
  ('turpis.nec.mauris@aol.edu','Evan Davidson','IAE82FXL5LU','magna. Sed eu eros. Nam consequat dolor vitae dolor. Donec fringilla. Donec',42),
  ('consequat.purus@aol.couk','Lamar Beck','DDV67EFE6VQ','dui. Suspendisse ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla',64),
  ('neque@yahoo.couk','Susan Payne','IFI95EZX3SF','quam dignissim pharetra. Nam ac nulla. In tincidunt congue turpis. In',20),
  ('dapibus.id@yahoo.ca','Fitzgerald Cleveland','MRJ75HRH2YJ','odio. Nam interdum enim non nisi. Aenean eget metus. In nec orci. Donec',25),
  ('massa.suspendisse.eleifend@yahoo.com','Latifah Beasley','LZJ89VVG4UR','in aliquet lobortis, nisi nibh lacinia orci, consectetuer euismod est arcu ac',51),
  ('sem.mollis.dui@google.ca','Quon Romero','HFQ41NBI3WY','Mauris magna. Duis dignissim tempor arcu. Vestibulum ut eros non enim commodo hendrerit. Donec porttitor',19),
  ('urna.nullam@yahoo.couk','Gannon Cook','NXS84NBT2FH','non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.',49),
  ('augue.eu@google.couk','Harrison Carroll','WLM90XNJ4CF','imperdiet ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin a, malesuada id, erat. Etiam vestibulum massa rutrum',54),
  ('curabitur.consequat@yahoo.net','Myra Moses','APG16LGR3HK','eget tincidunt dui augue eu tellus. Phasellus elit pede, malesuada vel, venenatis vel, faucibus id,',63),
  ('sem.semper@icloud.net','Kelly Reynolds','QZM67SCJ6LB','tellus non magna. Nam ligula elit, pretium et, rutrum non, hendrerit id, ante.',38),
  ('augue.malesuada@google.org','Porter Burns','FON06WAO6HP','sodales purus, in molestie tortor nibh sit amet orci. Ut sagittis lobortis mauris. Suspendisse aliquet molestie tellus. Aenean',49),
  ('lacinia.orci@outlook.net','Drake Jennings','KMJ13XJB8FX','et, lacinia vitae, sodales at, velit. Pellentesque ultricies dignissim lacus. Aliquam rutrum lorem ac risus. Morbi metus. Vivamus',65),
  ('ante.bibendum@yahoo.couk','Yael Gentry','BJS21FOC7NP','metus. Aliquam erat volutpat. Nulla facilisis. Suspendisse commodo tincidunt nibh. Phasellus nulla. Integer vulputate,',48),
  ('lobortis.ultrices@yahoo.org','Echo Brock','XFC80CWF2CY','conubia nostra, per inceptos hymenaeos. Mauris ut quam vel sapien imperdiet',56),
  ('sapien.imperdiet@protonmail.ca','Yuri Wolf','WEF44FGV4PT','et libero. Proin mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor vitae,',60),
  ('cras@outlook.org','Joelle Golden','TMJ48YRL8OO','mollis. Phasellus libero mauris, aliquam eu, accumsan sed, facilisis vitae, orci.',63),
  ('quam.elementum.at@google.couk','Quamar Reed','IXE84QCT6CX','egestas. Sed pharetra, felis eget varius ultrices, mauris ipsum porta elit, a feugiat tellus lorem eu metus. In',46),
  ('bibendum.ullamcorper@outlook.net','Boris Conley','CRB27VDL7PG','nunc est, mollis non, cursus non, egestas a, dui. Cras pellentesque. Sed dictum. Proin eget',52),
  ('lobortis.mauris@yahoo.ca','Kirsten Perkins','DXO23MFX1CH','leo elementum sem, vitae aliquam eros turpis non enim. Mauris quis turpis vitae purus gravida sagittis.',58),
  ('iaculis.nec@hotmail.edu','Marshall Lester','QPO55EEZ9UX','mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare,',32),
  ('consectetuer@hotmail.ca','Stephanie Berg','NTY96FCJ3NQ','nulla vulputate dui, nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper',36),
  ('et.magnis.dis@yahoo.org','Connor Bradford','BWC82QDJ3ZH','quis, pede. Praesent eu dui. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus',55),
  ('suscipit.nonummy.fusce@yahoo.com','Rhonda Harding','DOR85UXT2QN','enim, gravida sit amet, dapibus id, blandit at, nisi. Cum sociis natoque',58),
  ('varius.ultrices@hotmail.couk','Samuel Britt','XQO23TAT2DX','malesuada vel, venenatis vel, faucibus id, libero. Donec consectetuer mauris id sapien.',26),
  ('sollicitudin@icloud.org','Melodie Dunn','OKF45IRC1CT','vitae semper egestas, urna justo faucibus lectus, a sollicitudin orci sem eget massa.',37),
  ('auctor.vitae.aliquet@google.net','Lilah Haley','CSV32EMD8YX','Maecenas libero est, congue a, aliquet vel, vulputate eu, odio. Phasellus at augue id ante dictum cursus. Nunc mauris',40),
  ('urna@hotmail.org','Maya Fuller','RVL05APT2BW','a sollicitudin orci sem eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero. Integer in magna.',33),
  ('vulputate.nisi@yahoo.org','Vera Duffy','MDN65RPG1NH','Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla',50),
  ('vulputate.posuere.vulputate@icloud.com','Anthony Barnes','YTO46IGR8KM','aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem',21),
  ('sociis.natoque.penatibus@outlook.org','Solomon Flynn','ODA37DDN2CZ','non, hendrerit id, ante. Nunc mauris sapien, cursus in, hendrerit consectetuer, cursus et, magna. Praesent interdum ligula eu enim. Etiam',32),
  ('ullamcorper.nisl@google.edu','Amal Hensley','GLD32JSM0VG','ultrices iaculis odio. Nam interdum enim non nisi. Aenean eget metus. In nec orci. Donec nibh. Quisque nonummy',62),
  ('pede.blandit@icloud.couk','Holly Sellers','NGC36OGH3VC','elit fermentum risus, at fringilla purus mauris a nunc. In at pede. Cras vulputate velit eu sem.',21),
  ('non.dui@yahoo.net','Sylvia Melton','MFE97MIS1EU','Nam consequat dolor vitae dolor. Donec fringilla. Donec feugiat metus sit amet ante. Vivamus non lorem',38),
  ('imperdiet.ullamcorper@hotmail.edu','Tamara Stanley','CXL13ORL7LT','elit. Etiam laoreet, libero et tristique pellentesque, tellus sem mollis dui, in sodales elit erat vitae risus.',62),
  ('donec.egestas.aliquam@aol.ca','Genevieve Trevino','PVH01SSH1HL','sem egestas blandit. Nam nulla magna, malesuada vel, convallis in, cursus et,',30),
  ('velit.aliquam@icloud.edu','Todd Murray','SFS44XKD4QI','placerat, augue. Sed molestie. Sed id risus quis diam luctus lobortis. Class aptent taciti sociosqu ad litora',38),
  ('ante.nunc.mauris@hotmail.edu','Iris Cochran','DQV14PVU4CD','in aliquet lobortis, nisi nibh lacinia orci, consectetuer euismod est arcu ac orci. Ut semper pretium neque. Morbi quis',59),
  ('neque.morbi.quis@protonmail.ca','Jacob Chambers','HBE89ZVG6ME','fringilla est. Mauris eu turpis. Nulla aliquet. Proin velit. Sed malesuada augue ut lacus. Nulla tincidunt, neque vitae semper egestas,',22),
  ('quam.curabitur.vel@icloud.net','Hilda Hodges','PEZ31POP3ZT','a, scelerisque sed, sapien. Nunc pulvinar arcu et pede. Nunc sed',42),
  ('quam.vel@aol.ca','Gary Frazier','BKG43DZM1NF','semper et, lacinia vitae, sodales at, velit. Pellentesque ultricies dignissim lacus.',45),
  ('id.sapien.cras@outlook.edu','Veronica Head','JBH75NDR8YX','nisl arcu iaculis enim, sit amet ornare lectus justo eu arcu. Morbi sit amet',25),
  ('malesuada.vel@aol.edu','Kai Lester','EVL68CCQ1YL','dictum mi, ac mattis velit justo nec ante. Maecenas mi felis, adipiscing fringilla,',40),
  ('pede.ultrices@google.com','Raven Stark','ARZ11BVT1BT','Integer tincidunt aliquam arcu. Aliquam ultrices iaculis odio. Nam interdum enim non',43),
  ('et.risus@aol.couk','Irene Hickman','FMJ23BJQ6IA','aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor, dictum eu, placerat eget, venenatis a, magna.',33),
  ('odio@hotmail.edu','Mariam Franco','VCV36VHX7VR','eu tellus eu augue porttitor interdum. Sed auctor odio a purus. Duis',58),
  ('metus@icloud.net','Emmanuel Lindsay','XAG12JVQ7SJ','elit, dictum eu, eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur dictum. Phasellus in',64),
  ('libero.lacus@outlook.net','Paula Britt','MJQ17GOC3ZX','blandit enim consequat purus. Maecenas libero est, congue a, aliquet vel, vulputate eu,',63),
  ('ut.nisi@outlook.org','Lionel Guerrero','LKX42LHG9QM','lectus, a sollicitudin orci sem eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero. Integer',64),
  ('mattis@icloud.com','Boris Grant','FFJ31OWW8QG','Quisque porttitor eros nec tellus. Nunc lectus pede, ultrices a, auctor non, feugiat nec, diam. Duis mi',35),
  ('non.enim@icloud.org','Harriet Montgomery','OIW36UJT6XE','vel turpis. Aliquam adipiscing lobortis risus. In mi pede, nonummy ut, molestie in, tempus eu, ligula. Aenean euismod mauris',61),
  ('lectus.rutrum@aol.com','Rae Slater','HAR54DKA5CL','venenatis lacus. Etiam bibendum fermentum metus. Aenean sed pede nec ante blandit viverra. Donec tempus,',64),
  ('nunc.ac@icloud.edu','Mira Arnold','RNV37OHB4NV','metus. In lorem. Donec elementum, lorem ut aliquam iaculis, lacus pede',48),
  ('montes@protonmail.ca','Giacomo Booth','CJE41UCK3EJ','Duis cursus, diam at pretium aliquet, metus urna convallis erat, eget tincidunt dui augue',32),
  ('ac.tellus@yahoo.com','Berk Ewing','ECA42TUT2JY','Quisque fringilla euismod enim. Etiam gravida molestie arcu. Sed eu nibh vulputate mauris sagittis placerat. Cras',42),
  ('in.sodales@yahoo.ca','Cyrus Gates','YNL84IDU2QC','cursus purus. Nullam scelerisque neque sed sem egestas blandit. Nam nulla magna, malesuada vel, convallis',24),
  ('nulla@icloud.com','Brynn Reynolds','KBA21JAU9DM','lacus. Aliquam rutrum lorem ac risus. Morbi metus. Vivamus euismod urna. Nullam lobortis quam a felis ullamcorper viverra. Maecenas iaculis',64),
  ('mattis.integer@outlook.ca','Eaton Black','HTS38MBB4SP','eleifend non, dapibus rutrum, justo. Praesent luctus. Curabitur egestas nunc sed libero. Proin sed turpis nec mauris',63),
  ('convallis.in@icloud.com','Marshall Mcmillan','RCL68ZEG7PC','pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam, elementum at,',58),
  ('metus.eu.erat@protonmail.com','Gillian Montgomery','YJE44DFS5NQ','ante, iaculis nec, eleifend non, dapibus rutrum, justo. Praesent luctus. Curabitur egestas nunc sed libero. Proin sed',49),
  ('sed.id@hotmail.ca','Piper Cardenas','CLP46JVC6IW','Donec egestas. Aliquam nec enim. Nunc ut erat. Sed nunc est, mollis non, cursus non,',55),
  ('sagittis.duis@yahoo.net','Troy Cortez','WYF59SRI6ME','lectus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec dignissim magna',20),
  ('sed@protonmail.net','Wesley Espinoza','LGH23RCG0OY','sed dictum eleifend, nunc risus varius orci, in consequat enim diam vel',30),
  ('tincidunt.aliquam@yahoo.org','Grace Christensen','SEN83UVG6ZO','at risus. Nunc ac sem ut dolor dapibus gravida. Aliquam tincidunt, nunc ac mattis ornare, lectus ante',21),
  ('velit.justo@icloud.net','Lionel Harding','FIV78LOW2LX','amet, consectetuer adipiscing elit. Aliquam auctor, velit eget laoreet posuere, enim nisl elementum purus, accumsan interdum libero',24),
  ('elit.a@google.org','Brenden Mcfadden','KOH55HYN2AP','Morbi quis urna. Nunc quis arcu vel quam dignissim pharetra. Nam ac nulla. In tincidunt congue turpis.',20),
  ('donec@icloud.org','Jelani Valenzuela','UGD08INY4LB','aliquam adipiscing lacus. Ut nec urna et arcu imperdiet ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin',38),
  ('volutpat.ornare@aol.edu','Delilah Hurst','PXF21JRN5XC','Etiam bibendum fermentum metus. Aenean sed pede nec ante blandit viverra. Donec tempus, lorem fringilla ornare',59),
  ('nisl.arcu.iaculis@google.org','Edan Hodge','CHF83HEI8OK','ullamcorper magna. Sed eu eros. Nam consequat dolor vitae dolor. Donec fringilla. Donec feugiat',38),
  ('facilisis@protonmail.com','Lilah Sharpe','MDR22AJE5ZD','at, velit. Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue.',64),
  ('urna.vivamus@icloud.com','Kylynn Bailey','XMK78TSI3EI','vitae, posuere at, velit. Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue. Sed molestie. Sed id risus',18),
  ('aliquam@yahoo.couk','Michael Gamble','DWT64WRQ0YD','Nulla eu neque pellentesque massa lobortis ultrices. Vivamus rhoncus. Donec est. Nunc ullamcorper, velit',54),
  ('sed.nec.metus@outlook.org','Isaiah Munoz','JRK66IDU3SC','imperdiet non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem',48),
  ('pellentesque.massa@yahoo.com','Bruno Kramer','QQL12HFZ7CA','Sed nunc est, mollis non, cursus non, egestas a, dui. Cras pellentesque. Sed dictum. Proin eget odio. Aliquam vulputate',56),
  ('sit.amet.metus@outlook.couk','Donna Olsen','RRH84SQE4UW','nunc sed libero. Proin sed turpis nec mauris blandit mattis. Cras eget nisi',62),
  ('felis.donec.tempor@icloud.couk','Nicole Williams','OGH87PGM6DC','a sollicitudin orci sem eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero.',61),
  ('quis.lectus@google.com','Sierra Webb','EWD06GOK4JK','nonummy ut, molestie in, tempus eu, ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque. Sed eget lacus. Mauris',25);


INSERT INTO admins (id, accounts_id)
VALUES
  (1,49),
  (2,14),
  (3,86),
  (4,64),   
  (5,96),
  (6,50),
  (7,48),
  (8,2),
  (9,75),
  (10,51);


INSERT INTO users (id, accounts_id)
VALUES
  (1,1),
  (3,3),
  (4,4),
  (5,5),
  (6,6),
  (7,7),
  (8,8),
  (9,9),
  (10,10),
  (11,11),
  (12,12),
  (13,13),
  (15,15),
  (16,16),
  (17,17),
  (18,18),
  (19,19),
  (20,20),
  (21,21),
  (22,22),
  (23,23),
  (24,24),
  (25,25),
  (26,26),
  (27,27),
  (28,28),
  (29,29),
  (30,30),
  (31,31),
  (32,32),
  (33,33),
  (34,34),
  (35,35),
  (36,36),
  (37,37),
  (38,38),
  (39,39),
  (40,40),
  (41,41),
  (42,42),
  (43,43),
  (44,44),
  (45,45),
  (46,46),
  (47,47),
  (52,52),
  (53,53),
  (54,54),
  (55,55),
  (56,56),
  (57,57),
  (58,58),
  (59,59),
  (60,60),
  (61,61),
  (62,62),
  (63,63),
  (65,65),
  (66,66),
  (67,67),
  (68,68),
  (69,69),
  (70,70),
  (71,71),
  (72,72),
  (73,73),
  (74,74),
  (76,76),
  (77,77),
  (78,78),
  (79,79),
  (80,80),
  (81,81),
  (82,82),
  (83,83),
  (84,84),
  (85,85),
  (87,87),
  (88,88),
  (89,89),
  (90,90),
  (91,91),
  (92,92),
  (93,93),
  (94,94),
  (95,95),
  (97,97),
  (98,98),
  (99,99),
  (100,100);


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


INSERT INTO event_tags (event_id,tag_id)
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
