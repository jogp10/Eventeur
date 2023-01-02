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
drop table if exists requests CASCADE;
drop table if exists password_resets CASCADE;
DROP TYPE IF EXISTS privacy CASCADE;
-- Types
CREATE TYPE privacy as ENUM ('Private', 'Public');
-- Tables
CREATE TABLE accounts (
    id SERIAL PRIMARY KEY,
    email TEXT NOT NULL,
    name TEXT NOT NULL,
    password TEXT,
    description TEXT,
    age INTEGER CHECK (age > 0),
    remember_token TEXT,
    provider TEXT,
    provider_id TEXT,
    provider_refresh_token TEXT,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
    UNIQUE(email)
);
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    account_id INTEGER DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_accounts_id FOREIGN KEY(account_id) REFERENCES accounts(id) ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE admins (
    id SERIAL PRIMARY KEY,
    account_id INTEGER DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_account_id FOREIGN KEY(account_id) REFERENCES accounts(id) ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE events (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    description TEXT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    location TEXT NOT NULL,
    capacity INTEGER NOT NULL,
    privacy privacy DEFAULT 'Public',
    user_id INTEGER NOT NULL,
    ticket INTEGER NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES users(id),
    CHECK (start_date <= end_date),
    CHECK (capacity > 0)
);
CREATE TABLE cover_images (
    id SERIAL PRIMARY KEY,
    event_id INTEGER NOT NULL,
    name TEXT NOT NULL DEFAULT 'community-events.jpeg',
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) references events(id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE(event_id)
);
CREATE TABLE profile_images (
    id SERIAL PRIMARY KEY,
    user_id INTEGER DEFAULT 1,
    name TEXT NOT NULL DEFAULT 'perfil.png',
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE(user_id)
);
CREATE TABLE tags (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
    UNIQUE(name)
);
CREATE TABLE event_tag (
    id SERIAL PRIMARY KEY,
    event_id INTEGER NOT NULL,
    tag_id INTEGER NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) references events(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_tag_id FOREIGN KEY(tag_id) REFERENCES tags(id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE(event_id, tag_id)
);
CREATE TABLE tickets (
    id SERIAL PRIMARY KEY,
    event_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    num_of_tickets INTEGER NOT NULL,
    price REAL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) references events(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE(event_id, user_id)
);
CREATE TABLE invites (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    event_id INTEGER NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) references events(id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE(user_id, event_id)
);
CREATE TABLE requests (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    event_id INTEGER NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) references events(id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE(user_id, event_id)
);
CREATE TABLE notifications (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    content TEXT,
    seen BOOLEAN DEFAULT '0',
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW()
);
CREATE TABLE invite_notifications (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    notification_id INTEGER NOT NULL,
    invite_id INTEGER NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_notification_id FOREIGN KEY(notification_id) REFERENCES notifications(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_invite_id FOREIGN KEY(invite_id) REFERENCES invites(id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE(notification_id, invite_id)
);
CREATE TABLE comments (
    id SERIAL PRIMARY KEY,
    user_id INTEGER DEFAULT 1,
    event_id INTEGER NOT NULL,
    content TEXT NOT NULL,
    edited BOOLEAN DEFAULT '0',
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) references events(id) ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE comment_notifications (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    notification_id INTEGER NOT NULL,
    comment_id INTEGER NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_notification_id FOREIGN KEY(notification_id) REFERENCES notifications(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_comment_id FOREIGN KEY(comment_id) REFERENCES comments(id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE(notification_id, comment_id)
);
CREATE TABLE answers (
    id SERIAL PRIMARY KEY,
    comment_id INTEGER NOT NULL,
    user_id INTEGER DEFAULT 1,
    content TEXT NOT NULL,
    edited BOOLEAN DEFAULT '0',
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_comment_id FOREIGN KEY(comment_id) REFERENCES comments(id) ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE polls (
    id SERIAL PRIMARY KEY,
    event_id INTEGER NOT NULL,
    question TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) references events(id) ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE poll_options (
    id SERIAL PRIMARY KEY,
    poll_id INTEGER NOT NULL,
    description TEXT NOT NULL,
    votes INTEGER DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_poll_id FOREIGN KEY(poll_id) REFERENCES polls(id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE(id, poll_id)
);
CREATE TABLE votes (
    id SERIAL PRIMARY KEY,
    user_id INTEGER DEFAULT 1,
    poll_option_id INTEGER,
    event_id INTEGER,
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
VALUES (
        'anonymous@anonymous.com',
        'deleted account',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'deleted account',
        999
    ),
    (
        'ante.ipsum@icloud.org',
        'Tobias Rodriquez',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'enim diam vel arcu. Curabitur ut odio vel est tempor bibendum. Donec felis orci, adipiscing',
        18
    ),
    (
        'purus.ac@aol.org',
        'Clark Franklin',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'nascetur ridiculus mus. Aenean eget magna. Suspendisse tristique neque venenatis lacus. Etiam bibendum fermentum metus. Aenean sed pede nec ante',
        53
    ),
    (
        'iaculis.lacus@outlook.couk',
        'Inez Hopper',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'Cras sed leo. Cras vehicula aliquet libero. Integer in magna. Phasellus dolor elit, pellentesque a, facilisis non, bibendum sed,',
        54
    ),
    (
        'egestas@yahoo.ca',
        'Lani Herrera',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'rhoncus id, mollis nec, cursus a, enim. Suspendisse aliquet, sem ut cursus luctus, ipsum',
        61
    ),
    (
        'in.tempus.eu@outlook.edu',
        'Wade Hayden',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'lacus pede sagittis augue, eu tempor erat neque non quam. Pellentesque habitant morbi tristique',
        55
    ),
    (
        'venenatis.a.magna@protonmail.org',
        'Omar Bennett',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'tellus sem mollis dui, in sodales elit erat vitae risus. Duis a mi fringilla mi lacinia mattis. Integer eu lacus.',
        22
    ),
    (
        'urna.nec@hotmail.net',
        'Adele Mullen',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'mauris ut mi. Duis risus odio, auctor vitae, aliquet nec, imperdiet nec,',
        25
    ),
    (
        'magna.et@yahoo.net',
        'Madonna Norris',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'neque. Nullam ut nisi a odio semper cursus. Integer mollis. Integer tincidunt aliquam arcu. Aliquam ultrices',
        22
    ),
    (
        'vitae.sodales@google.org',
        'Fay Frye',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'aliquam iaculis, lacus pede sagittis augue, eu tempor erat neque',
        44
    ),
    (
        'ipsum@hotmail.ca',
        'Vernon Molina',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'Aliquam ultrices iaculis odio. Nam interdum enim non nisi. Aenean eget metus. In nec orci. Donec nibh. Quisque nonummy ipsum',
        48
    ),
    (
        'consequat.lectus@aol.edu',
        'Dacey Christian',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'urna et arcu imperdiet ullamcorper. Duis at lacus. Quisque purus sapien, gravida',
        63
    ),
    (
        'integer.mollis.integer@outlook.org',
        'Aspen Giles',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'dictum. Proin eget odio. Aliquam vulputate ullamcorper magna. Sed eu eros. Nam consequat dolor vitae dolor. Donec fringilla. Donec',
        50
    ),
    (
        'lobortis.nisi@yahoo.net',
        'Cherokee Kinney',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'Donec sollicitudin adipiscing ligula. Aenean gravida nunc sed pede. Cum sociis natoque penatibus',
        57
    ),
    (
        'dolor.fusce@protonmail.couk',
        'Knox Brock',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'odio, auctor vitae, aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non, vestibulum nec, euismod',
        59
    ),
    (
        'dictum@google.net',
        'Mara Farrell',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'neque. Sed eget lacus. Mauris non dui nec urna suscipit nonummy. Fusce fermentum fermentum arcu. Vestibulum ante ipsum',
        56
    ),
    (
        'dictum.proin@outlook.ca',
        'Macy Dorsey',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'Donec egestas. Aliquam nec enim. Nunc ut erat. Sed nunc est, mollis non, cursus non,',
        29
    ),
    (
        'cras.eget.nisi@icloud.net',
        'Kareem Walton',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'nisl sem, consequat nec, mollis vitae, posuere at, velit. Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue.',
        54
    ),
    (
        'quisque@protonmail.edu',
        'Linda Mason',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'erat vel pede blandit congue. In scelerisque scelerisque dui. Suspendisse ac metus vitae',
        39
    ),
    (
        'ante@icloud.com',
        'Mason Jennings',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'nunc. In at pede. Cras vulputate velit eu sem. Pellentesque ut ipsum ac mi eleifend egestas.',
        35
    ),
    (
        'mauris@outlook.org',
        'Chaney Tillman',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue. Sed molestie. Sed id risus quis',
        35
    ),
    (
        'integer.tincidunt.aliquam@aol.edu',
        'Ferris Davenport',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'nibh. Phasellus nulla. Integer vulputate, risus a ultricies adipiscing, enim',
        37
    ),
    (
        'lacus.etiam@aol.ca',
        'Palmer Barber',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'consequat enim diam vel arcu. Curabitur ut odio vel est tempor bibendum. Donec felis orci, adipiscing non, luctus sit',
        44
    ),
    (
        'nisi.nibh@yahoo.ca',
        'Hammett Wall',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'sed dolor. Fusce mi lorem, vehicula et, rutrum eu, ultrices sit amet, risus.',
        44
    ),
    (
        'turpis.nec.mauris@aol.edu',
        'Evan Davidson',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'magna. Sed eu eros. Nam consequat dolor vitae dolor. Donec fringilla. Donec',
        42
    ),
    (
        'consequat.purus@aol.couk',
        'Lamar Beck',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'dui. Suspendisse ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla',
        64
    ),
    (
        'neque@yahoo.couk',
        'Susan Payne',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'quam dignissim pharetra. Nam ac nulla. In tincidunt congue turpis. In',
        20
    ),
    (
        'dapibus.id@yahoo.ca',
        'Fitzgerald Cleveland',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'odio. Nam interdum enim non nisi. Aenean eget metus. In nec orci. Donec',
        25
    ),
    (
        'massa.suspendisse.eleifend@yahoo.com',
        'Latifah Beasley',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'in aliquet lobortis, nisi nibh lacinia orci, consectetuer euismod est arcu ac',
        51
    ),
    (
        'sem.mollis.dui@google.ca',
        'Quon Romero',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'Mauris magna. Duis dignissim tempor arcu. Vestibulum ut eros non enim commodo hendrerit. Donec porttitor',
        19
    ),
    (
        'urna.nullam@yahoo.couk',
        'Gannon Cook',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.',
        49
    ),
    (
        'augue.eu@google.couk',
        'Harrison Carroll',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'imperdiet ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin a, malesuada id, erat. Etiam vestibulum massa rutrum',
        54
    ),
    (
        'curabitur.consequat@yahoo.net',
        'Myra Moses',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'eget tincidunt dui augue eu tellus. Phasellus elit pede, malesuada vel, venenatis vel, faucibus id,',
        63
    ),
    (
        'sem.semper@icloud.net',
        'Kelly Reynolds',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'tellus non magna. Nam ligula elit, pretium et, rutrum non, hendrerit id, ante.',
        38
    ),
    (
        'augue.malesuada@google.org',
        'Porter Burns',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'sodales purus, in molestie tortor nibh sit amet orci. Ut sagittis lobortis mauris. Suspendisse aliquet molestie tellus. Aenean',
        49
    ),
    (
        'lacinia.orci@outlook.net',
        'Drake Jennings',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'et, lacinia vitae, sodales at, velit. Pellentesque ultricies dignissim lacus. Aliquam rutrum lorem ac risus. Morbi metus. Vivamus',
        65
    ),
    (
        'ante.bibendum@yahoo.couk',
        'Yael Gentry',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'metus. Aliquam erat volutpat. Nulla facilisis. Suspendisse commodo tincidunt nibh. Phasellus nulla. Integer vulputate,',
        48
    ),
    (
        'lobortis.ultrices@yahoo.org',
        'Echo Brock',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'conubia nostra, per inceptos hymenaeos. Mauris ut quam vel sapien imperdiet',
        56
    ),
    (
        'sapien.imperdiet@protonmail.ca',
        'Yuri Wolf',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'et libero. Proin mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor vitae,',
        60
    ),
    (
        'cras@outlook.org',
        'Joelle Golden',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'mollis. Phasellus libero mauris, aliquam eu, accumsan sed, facilisis vitae, orci.',
        63
    ),
    (
        'quam.elementum.at@google.couk',
        'Quamar Reed',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'egestas. Sed pharetra, felis eget varius ultrices, mauris ipsum porta elit, a feugiat tellus lorem eu metus. In',
        46
    ),
    (
        'bibendum.ullamcorper@outlook.net',
        'Boris Conley',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'nunc est, mollis non, cursus non, egestas a, dui. Cras pellentesque. Sed dictum. Proin eget',
        52
    ),
    (
        'lobortis.mauris@yahoo.ca',
        'Kirsten Perkins',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'leo elementum sem, vitae aliquam eros turpis non enim. Mauris quis turpis vitae purus gravida sagittis.',
        58
    ),
    (
        'iaculis.nec@hotmail.edu',
        'Marshall Lester',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare,',
        32
    ),
    (
        'consectetuer@hotmail.ca',
        'Stephanie Berg',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'nulla vulputate dui, nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper',
        36
    ),
    (
        'et.magnis.dis@yahoo.org',
        'Connor Bradford',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'quis, pede. Praesent eu dui. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus',
        55
    ),
    (
        'suscipit.nonummy.fusce@yahoo.com',
        'Rhonda Harding',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'enim, gravida sit amet, dapibus id, blandit at, nisi. Cum sociis natoque',
        58
    ),
    (
        'varius.ultrices@hotmail.couk',
        'Samuel Britt',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'malesuada vel, venenatis vel, faucibus id, libero. Donec consectetuer mauris id sapien.',
        26
    ),
    (
        'sollicitudin@icloud.org',
        'Melodie Dunn',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'vitae semper egestas, urna justo faucibus lectus, a sollicitudin orci sem eget massa.',
        37
    ),
    (
        'auctor.vitae.aliquet@google.net',
        'Lilah Haley',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'Maecenas libero est, congue a, aliquet vel, vulputate eu, odio. Phasellus at augue id ante dictum cursus. Nunc mauris',
        40
    ),
    (
        'urna@hotmail.org',
        'Maya Fuller',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'a sollicitudin orci sem eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero. Integer in magna.',
        33
    ),
    (
        'vulputate.nisi@yahoo.org',
        'Vera Duffy',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla',
        50
    ),
    (
        'vulputate.posuere.vulputate@icloud.com',
        'Anthony Barnes',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem',
        21
    ),
    (
        'sociis.natoque.penatibus@outlook.org',
        'Solomon Flynn',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'non, hendrerit id, ante. Nunc mauris sapien, cursus in, hendrerit consectetuer, cursus et, magna. Praesent interdum ligula eu enim. Etiam',
        32
    ),
    (
        'ullamcorper.nisl@google.edu',
        'Amal Hensley',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'ultrices iaculis odio. Nam interdum enim non nisi. Aenean eget metus. In nec orci. Donec nibh. Quisque nonummy',
        62
    ),
    (
        'pede.blandit@icloud.couk',
        'Holly Sellers',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'elit fermentum risus, at fringilla purus mauris a nunc. In at pede. Cras vulputate velit eu sem.',
        21
    ),
    (
        'non.dui@yahoo.net',
        'Sylvia Melton',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'Nam consequat dolor vitae dolor. Donec fringilla. Donec feugiat metus sit amet ante. Vivamus non lorem',
        38
    ),
    (
        'imperdiet.ullamcorper@hotmail.edu',
        'Tamara Stanley',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'elit. Etiam laoreet, libero et tristique pellentesque, tellus sem mollis dui, in sodales elit erat vitae risus.',
        62
    ),
    (
        'donec.egestas.aliquam@aol.ca',
        'Genevieve Trevino',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'sem egestas blandit. Nam nulla magna, malesuada vel, convallis in, cursus et,',
        30
    ),
    (
        'velit.aliquam@icloud.edu',
        'Todd Murray',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'placerat, augue. Sed molestie. Sed id risus quis diam luctus lobortis. Class aptent taciti sociosqu ad litora',
        38
    ),
    (
        'ante.nunc.mauris@hotmail.edu',
        'Iris Cochran',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'in aliquet lobortis, nisi nibh lacinia orci, consectetuer euismod est arcu ac orci. Ut semper pretium neque. Morbi quis',
        59
    ),
    (
        'neque.morbi.quis@protonmail.ca',
        'Jacob Chambers',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'fringilla est. Mauris eu turpis. Nulla aliquet. Proin velit. Sed malesuada augue ut lacus. Nulla tincidunt, neque vitae semper egestas,',
        22
    ),
    (
        'quam.curabitur.vel@icloud.net',
        'Hilda Hodges',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'a, scelerisque sed, sapien. Nunc pulvinar arcu et pede. Nunc sed',
        42
    ),
    (
        'quam.vel@aol.ca',
        'Gary Frazier',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'semper et, lacinia vitae, sodales at, velit. Pellentesque ultricies dignissim lacus.',
        45
    ),
    (
        'id.sapien.cras@outlook.edu',
        'Veronica Head',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'nisl arcu iaculis enim, sit amet ornare lectus justo eu arcu. Morbi sit amet',
        25
    ),
    (
        'malesuada.vel@aol.edu',
        'Kai Lester',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'dictum mi, ac mattis velit justo nec ante. Maecenas mi felis, adipiscing fringilla,',
        40
    ),
    (
        'pede.ultrices@google.com',
        'Raven Stark',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'Integer tincidunt aliquam arcu. Aliquam ultrices iaculis odio. Nam interdum enim non',
        43
    ),
    (
        'et.risus@aol.couk',
        'Irene Hickman',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor, dictum eu, placerat eget, venenatis a, magna.',
        33
    ),
    (
        'odio@hotmail.edu',
        'Mariam Franco',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'eu tellus eu augue porttitor interdum. Sed auctor odio a purus. Duis',
        58
    ),
    (
        'metus@icloud.net',
        'Emmanuel Lindsay',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'elit, dictum eu, eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur dictum. Phasellus in',
        64
    ),
    (
        'libero.lacus@outlook.net',
        'Paula Britt',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'blandit enim consequat purus. Maecenas libero est, congue a, aliquet vel, vulputate eu,',
        63
    ),
    (
        'ut.nisi@outlook.org',
        'Lionel Guerrero',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'lectus, a sollicitudin orci sem eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero. Integer',
        64
    ),
    (
        'mattis@icloud.com',
        'Boris Grant',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'Quisque porttitor eros nec tellus. Nunc lectus pede, ultrices a, auctor non, feugiat nec, diam. Duis mi',
        35
    ),
    (
        'non.enim@icloud.org',
        'Harriet Montgomery',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'vel turpis. Aliquam adipiscing lobortis risus. In mi pede, nonummy ut, molestie in, tempus eu, ligula. Aenean euismod mauris',
        61
    ),
    (
        'lectus.rutrum@aol.com',
        'Rae Slater',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'venenatis lacus. Etiam bibendum fermentum metus. Aenean sed pede nec ante blandit viverra. Donec tempus,',
        64
    ),
    (
        'nunc.ac@icloud.edu',
        'Mira Arnold',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'metus. In lorem. Donec elementum, lorem ut aliquam iaculis, lacus pede',
        48
    ),
    (
        'montes@protonmail.ca',
        'Giacomo Booth',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'Duis cursus, diam at pretium aliquet, metus urna convallis erat, eget tincidunt dui augue',
        32
    ),
    (
        'ac.tellus@yahoo.com',
        'Berk Ewing',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'Quisque fringilla euismod enim. Etiam gravida molestie arcu. Sed eu nibh vulputate mauris sagittis placerat. Cras',
        42
    ),
    (
        'in.sodales@yahoo.ca',
        'Cyrus Gates',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'cursus purus. Nullam scelerisque neque sed sem egestas blandit. Nam nulla magna, malesuada vel, convallis',
        24
    ),
    (
        'nulla@icloud.com',
        'Brynn Reynolds',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'lacus. Aliquam rutrum lorem ac risus. Morbi metus. Vivamus euismod urna. Nullam lobortis quam a felis ullamcorper viverra. Maecenas iaculis',
        64
    ),
    (
        'mattis.integer@outlook.ca',
        'Eaton Black',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'eleifend non, dapibus rutrum, justo. Praesent luctus. Curabitur egestas nunc sed libero. Proin sed turpis nec mauris',
        63
    ),
    (
        'convallis.in@icloud.com',
        'Marshall Mcmillan',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam, elementum at,',
        58
    ),
    (
        'metus.eu.erat@protonmail.com',
        'Gillian Montgomery',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'ante, iaculis nec, eleifend non, dapibus rutrum, justo. Praesent luctus. Curabitur egestas nunc sed libero. Proin sed',
        49
    ),
    (
        'sed.id@hotmail.ca',
        'Piper Cardenas',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'Donec egestas. Aliquam nec enim. Nunc ut erat. Sed nunc est, mollis non, cursus non,',
        55
    ),
    (
        'sagittis.duis@yahoo.net',
        'Troy Cortez',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'lectus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec dignissim magna',
        20
    ),
    (
        'sed@protonmail.net',
        'Wesley Espinoza',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'sed dictum eleifend, nunc risus varius orci, in consequat enim diam vel',
        30
    ),
    (
        'tincidunt.aliquam@yahoo.org',
        'Grace Christensen',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'at risus. Nunc ac sem ut dolor dapibus gravida. Aliquam tincidunt, nunc ac mattis ornare, lectus ante',
        21
    ),
    (
        'velit.justo@icloud.net',
        'Lionel Harding',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'amet, consectetuer adipiscing elit. Aliquam auctor, velit eget laoreet posuere, enim nisl elementum purus, accumsan interdum libero',
        24
    ),
    (
        'elit.a@google.org',
        'Brenden Mcfadden',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'Morbi quis urna. Nunc quis arcu vel quam dignissim pharetra. Nam ac nulla. In tincidunt congue turpis.',
        20
    ),
    (
        'donec@icloud.org',
        'Jelani Valenzuela',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'aliquam adipiscing lacus. Ut nec urna et arcu imperdiet ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin',
        38
    ),
    (
        'volutpat.ornare@aol.edu',
        'Delilah Hurst',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'Etiam bibendum fermentum metus. Aenean sed pede nec ante blandit viverra. Donec tempus, lorem fringilla ornare',
        59
    ),
    (
        'nisl.arcu.iaculis@google.org',
        'Edan Hodge',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'ullamcorper magna. Sed eu eros. Nam consequat dolor vitae dolor. Donec fringilla. Donec feugiat',
        38
    ),
    (
        'facilisis@protonmail.com',
        'Lilah Sharpe',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'at, velit. Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue.',
        64
    ),
    (
        'urna.vivamus@icloud.com',
        'Kylynn Bailey',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'vitae, posuere at, velit. Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue. Sed molestie. Sed id risus',
        18
    ),
    (
        'aliquam@yahoo.couk',
        'Michael Gamble',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'Nulla eu neque pellentesque massa lobortis ultrices. Vivamus rhoncus. Donec est. Nunc ullamcorper, velit',
        54
    ),
    (
        'sed.nec.metus@outlook.org',
        'Isaiah Munoz',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'imperdiet non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem',
        48
    ),
    (
        'pellentesque.massa@yahoo.com',
        'Bruno Kramer',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'Sed nunc est, mollis non, cursus non, egestas a, dui. Cras pellentesque. Sed dictum. Proin eget odio. Aliquam vulputate',
        56
    ),
    (
        'sit.amet.metus@outlook.couk',
        'Donna Olsen',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'nunc sed libero. Proin sed turpis nec mauris blandit mattis. Cras eget nisi',
        62
    ),
    (
        'felis.donec.tempor@icloud.couk',
        'Nicole Williams',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'a sollicitudin orci sem eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero.',
        61
    ),
    (
        'quis.lectus@google.com',
        'Sierra Webb',
        '$2y$10$yRM.Bvvgwoj8GXC3VrRzuO9CSLpNx3r8zZHrnlZtAK7lzmW5lYMxe',
        'nonummy ut, molestie in, tempus eu, ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque. Sed eget lacus. Mauris',
        25
    ),
    (
        'johndoe@fe.up.pt',
        'John Doe',
        '$2y$10$1n1Mta/k896NGbgQLIfY1uyYgA3rDOm5Q2xOqoeutmgCuuocdeexe',
        'Hey, Im John Doe',
        22
    ),
    (
        'admin1@fe.up.pt',
        'admin1',
        '$2y$10$BSs2Kg/G.r3fE5oPUD/6CObVNX9touzKQFAG24uQXORT5gED.NzAa',
        'admin1',
        1
    );
INSERT INTO admins (account_id)
VALUES (49),
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
INSERT INTO events (
        user_id,
        name,
        description,
        start_date,
        end_date,
        location,
        capacity,
        privacy
    )
VALUES (
        45,
        'Romantic Porto: Outdoor Escape Game for Couples - The Love Novel',
        'Dinner and a movie is so 2021! Especially when the movie is now played out in the real-world. Let us explain!

Were inviting you both (or you three - hey, we dont judge) to do one of the romantic-themed open-air escape games in Porto.

The route youre going to follow in the city is sprinkled with charming and picturesque places, fun clues and challenges, and romantic stories of past and present.

The experience will play out like youre the main characters of a movie, only that youre experiencing everything in first person! Fun dialogue, intrigue, and unexpected interactions are guaranteed.

Lets play a real-world adventure!',
        '2023-01-28 18:00',
        '2023-01-28 19:30',
        'Fonte dos Leões, 10 Praça de Gomes Teixeira, Porto, Portugal',
        417,
        'Public'
    ),
    (
        98,
        'Lionesa Yoga Sessions',
        'Lionesa welcomes Yoga Sessions, every Monday at 18h in Jardim da Lionesa - in front of Hilti Academy - limited to 10 people per session.',
        '2023-01-02 18:00',
        '2023-01-02 18:30',
        'Lionesa Business Hub Rua Lionesa 4465-671 Leça do Balio',
        380,
        'Public'
    ),
    (
        16,
        'Spiritus',
        'See Spiritus, an immersive multimedia experience at Clérigos Church.',
        '2023-01-02 17:30',
        '2023-11-23 23:59',
        'Clerigos Church and Tower',
        204,
        'Public'
    ),
    (
        59,
        'Restarting life International Conference',
        'Our community is growing and becoming more vibrant every single day. Restarting life‘s ultimate goal is to reach everyone around the world.At Restarting life you find a global group of like-minded people, and future partners, with new perspectives and an unshakeable hope to improve our current standards. Your collaboration and participation in our events is a key part of our strategy. Together we believe we will have a global impact.This year’s event is reaching people from several countries worldwide. We would like to thank you, and let you know that we consider you as part of the Restarting life community. We are beyond grateful for your support, and we hope we can have you even more involved with our group. We have so much to achieve together. ',
        '2021-01-05 09:00',
        '2021-01-05 19:00',
        'Maia, Portugal',
        58,
        'Public'
    ),
    (
        83,
        'JAZZ on SUNDAY- Domingos',
        '',
        '2023-01-01',
        '2023-08-23',
        'Praça de Carlos Alberto 121, 4050-526 Porto',
        204,
        'Public'
    ),
    (
        39,
        '
Exposição “Fictional Grounds” do coletivo berru
',
        'Simulações de solos de um território imaginado através das quais se pode procurar vestígios de minerais com potencial energético. Apresentar amostras de terra provenientes de diferentes origens com composições variadas que são montadas em planos bidimensionais – é esta realidade ficcionada que se poderá assistir de perto na nova exposição “Fictional Grounds” do coletivo artístico berru criado no Porto, que venceu o prémio Sonae Media Art 2019, e que já expôs e foi responsável por instalações em instituições como a Fundação Calouste Gulbenkian, BoCA Biennial of Contemporary Arts, e The Old Truman Brewey (Londres). A exposição conta com curadoria de Nuno Crespo, diretor da Escola das Artes da Universidade Católica Portuguesa. A inauguração tem data marcada para 20 de outubro, às 19h00 na Escola das Artes. A entrada é livre.

A exposição será apresentada ao público através de planos bidimensionais e colocados no espaço expositivo como se de pinturas ou esculturas minimalistas se tratassem. Vista de uma forma crítica e movida pela urgência da catástrofe ecológica atual, a exposição estabelece uma relação subtil com o universo dos earthworks (trabalhos com terra) dos artistas pioneiros da Land Art como Robert Smithson, Richard Long ou com a famosa exposição de Walter de Maria quando em 1977 encheu uma galeria de Nova Iorque com 140 toneladas de terra.',
        '2023-02-07',
        '2023-02-07',
        ' Rua Diogo de Botelho, 1327 - Porto',
        355,
        'Public'
    ),
    (
        79,
        'Circo Coliseu Porto Ageas 2022',
        'O Circo do Coliseu é para todos, a partir dos 0 (zero anos).
Todas as sessões do Circo, em qualquer horário da carreira, são Sessões Descontraídas*, sendo permitido sair da sala e voltar a entrar.
Encontra-se ao dispor a Sala de Conforto – espaço de tranquilidade para espectadores de todas as idades (e acompanhante) que estejam a sentir ansiedade ou necessitem de um momento de calma. Equipada com mobiliário de descanso, abafadores de ruído e objetos de estimulação sensorial, a Sala de Conforto pode ser utilizada para a descompressão (e voltar a participar do espetáculo) e também para a amamentação.',
        '2023-01-01',
        '2023-01-07',
        'Coliseu Porto',
        324,
        'Public'
    ),
    (
        19,
        'SEA LIFE PORTO',
        'O Sea Life do Porto é o segundo maior aquário de Portugal, atrás apenas do Oceanário de Lisboa. Conta com mais de 3.000 espécies de animais que vão desde pinguins até tubarões, passando por raias e impressionantes tartarugas gigantes.

O aquário está junto ao Parque da Cidade, por isso é um lugar ideal para visitar com crianças de maneira conjunta.     Faça um passeio em família ao SEA LIFE Porto e aprenda sobre a vida marinha – poderá ver até a alimentação dos tubarões e raias!
    Veja as criaturas marinhas que habitam este aquário no Porto, incluindo os habitantes do Porto dos Pinguins
    Explore um aquário voltado para a conservação, que participa em programas de proteção e reprodução de habitats

Ao visitar o SEA LIFE Porto com estes bilhetes, poderá pôr as mãos nas Piscinas Rochosas e se maravilhar com o hipnotizante Túnel Oceânico deste oceanário do Porto! Ainda ficará cara a cara com medusas, cavalos-marinhos, pinguins, um polvo e muitos outros animais marinhos. Passe metade do seu dia (ou um dia inteiro) aqui e fique a conhecer o ambiente submarino a sério.

O SEA LIFE Porto foi inaugurado em 2009 e, tal como as águas do Atlântico Norte nas proximidades, está repleto de vida aquática. Existem inúmeras criaturas marinhas neste aquário no Porto, desde estrelas-do-mar a tubarões.',
        '2023-01-02',
        '2026-02-03',
        'SEA LIFE Porto',
        361,
        'Public'
    ),
    (
        45,
        'international conference preserving life',
        'Our community is growing and becoming more vibrant every single day. Our ultimate goal is to reach everyone around the world.

At Preserving Life you find a global group of like-minded people, and future partners, with new perspectives and an unshakeable hope to improve our current standards. Your collaboration and participation in our events is a key part of our strategy. Together we believe we will have a global impact.

This year’s event is reaching people from several countries worldwide. We would like to thank you, and let you know that we consider you as part of the Preserving Life’ community. We are beyond grateful for your support, and we hope we can have you even more involved with our group. We have so much to achieve together.

On behalf of the entire team of Preserving Life, we would like to end this letter with a profoundly sincere “Thank You”… We are honoured to have you with us… Together we will accomplish our most ambitious goals.',
        '2023-01-06',
        '2023-01-06 23:59',
        'Porto',
        274,
        'Public'
    ),
    (
        15,
        'Exposição | “Justus", de Paulo Neves',
        'té 31 de Janeiro, os Passos Perdidos do Palácio da Justiça - no terceiro piso do Tribunal da Relação do Porto - acolhem a exposição de escultura “Justus”, de Paulo Neves, que apresenta 10 peças concebidas a partir de um carvalho americano centenário que habitou a Casa do Campo Pequeno – antigo Palacete Pinto Leite.

A queda aparatosa, em 2021, deu origem a um trabalho artístico que expressa uma nova vida e, sobretudo, a ideia de justiça. Desafiado por António Moutinho Cardoso e por Adélio Gomes, o escultor Paulo Neves transformou cerca de uma dezena de troncos da velha árvore em esculturas de diferentes dimensões – tendo a maior cerca de 3 metros.

O escultor Paulo Neves define este trabalho como “uma linguagem negra, uma solenidade própria da imagem que em criança criamos dos juízes. A dimensão, o silêncio, a imponência de cada figura lembra-nos que todos tentamos ser justos embora a condição humana nos consciencialize de que todos erramos".

A entrada é livre.',
        '2022-09-13',
        '2023-01-31',
        'Tribunal da Relação do Porto - Porto',
        475,
        'Private'
    ),
    (
        71,
        'Exposição | Walking Art Maps',
        'A exposição Walking Art Maps – #asbelasarteseacidade, especialmente dedicada aos estudantes internacionais, no âmbito dos 35 anos ERASMUS+, inaugura esta quarta-feira, no Pavilhão de Exposições da Faculdade de Belas Artes da U. Porto (FBAUP).

Na exposição, são reunidos trabalhos da coleção da FBAUP que se associam através de a obras instaladas em espaços públicos e privados, facilmente acessíveis. Propõem-se seis percursos, onde são identificadas obras de alguns dos artistas, arquitetos e designers das Belas Artes do Porto, que pontuam e caracterizam a cidade de variadas formas.

Walking Art Maps desdobra-se entre o Pavilhão de Exposições da FBAUP e uma plataforma online.

Informação completa na página da FBAUP.
',
        '2022-10-26',
        '2023-01-14',
        'Faculdade das Belas Artes - Porto',
        364,
        'Private'
    ),
    (
        83,
        'Música e ciência | MUSIC4L-MENTE',
        'O Mosteiro de São Bento da Vitória vai receber pela segunda vez o ciclo MUSIC4L-MENTE, uma parceria entre o DSCH – Schostakovich Ensemble, o Ministério da Ciência, Tecnologia e Ensino Superior e o Teatro Nacional São João. O primeiro concerto é já no dia 21 de dezembro.

Ciclo de concertos procura explorar a interdisciplinaridade entre a música e a ciência em concertos de música de câmara. Serão interpretadas obras de referência de grandes compositores dos séculos XVIII ao XXI. As atuações são precedidas por prelúdios científicos, que exploram o cruzamento entre a música e a ciência (da astrofísica e da matemática às neurociências), a cargo de nomes relevantes do mundo científico. O pianista e diretor artístico Filipe Pinto-Ribeiro continua a assegurar a curadoria do projeto.

Informação completa na página do Teatro Nacional São João.
',
        '2022-12-21',
        '2023-07-29',
        'Mosteiro de São Bento da Vitória - Porto',
        73,
        'Public'
    ),
    (
        5,
        'CURSO DE DESENHO DE OBSERVAÇÃO',
        'De 8 de Outubro 2022 a 31 de Maio 2023 - 62 sessões de 2h30- 155h
Horário - Quartas das 19h00 às 21h30 e Sábados das 10h30 às 13h00
Professores - Carlos Pinheiro, Diogo Nogueira e Nuno Sousa

Para mais informações visitem o site: https://clubedesenho.wordpress.com/
email: clubedesenho@gmail.com
',
        '2023-05-03 14:00',
        '2023-05-03 16:00',
        'Rua da Alegria 970 - Porto',
        493,
        'Public'
    ),
    (
        76,
        'Yoga com Katrina Satpreet',
        'AULAS KUNDALINI YOGA COM KATRINA SATPREET 
Presencial e Online

.
Aprende as técnicas de Kundalini Yoga com a Katrina Satpreet para experimentares a alegria e a prosperidade em tudo o que fazes! A prática de Kundalini irá transformar o teu nível interior, que por sua vez, também mudará a tua perspetiva com o mundo que te rodeia. Desta forma começas atrair novas possibilidades a tua vida. Através de Kundalini Yoga habilitas a sabedoria e paz interior para viver uma vida propositada, cheio de luz e tranquilidade. 
. 
Local:
Sound Temple, Arcozelo - VN Gaia 

Horários:
Quartas e Terças 19:30-21:00 e Sextas 10:30-12:00',
        '2021-07-15',
        '2024-03-31',
        'Arcozelo (Vila Nova e Gaia)',
        474,
        'Public'
    ),
    (
        88,
        'Circo Contemporâneo "Passagers" estreia no Coliseu do Porto em Fevereiro',
        '“Toda a produção é incrível. “Passagers” usa a arte circense não apenas como um espetáculo, mas como uma ferramenta para contar histórias imersivas. O inesperado dessas acrobacias dramáticas faz o espetáculo realmente parecer mágico. A beleza e engenhosidade deste espetáculo tornam-no imperdível para todos os públicos.» - The Harvard Crimson, EUA

O novo espetáculo “Passagers” do coletivo circense fundado no Canadá por ex-artistas do Cirque du Soleil, Les 7 Doigts, estreia em Portugal no dia 11 de Fevereiro no Coliseu do Porto.
 
“Passagers” é um circo contemporâneo que apresenta uma história sobre uma viagem de comboio, em que estranhos se encontram. Inspirados no movimento e na transição do curso, contam as suas histórias feitas de fugas e encontros. À medida que a cadência da viagem respira o seu ritmo na paisagem sonora, revelando o conteúdo da sua bagagem, eles revelam-se ao público. Dirigido com maestria fascinante por Shana Carroll, o espetáculo desenrola-se numa série de cenas, como um comboio em alta velocidade.',
        '2023-02-11 21:00',
        '2023-02-11 23:00',
        'Coliseu do Porto - Porto',
        89,
        'Public'
    ),
    (
        87,
        '“Atreve-te e leva”',
        '3 a 31 de janeiro

Biblioteca Municipal da Maia

“Atreve-te e leva”

Este projeto pretende oferecer aos leitores kits literários surpresa. Cada kit literário terá uma temática e será constituído por vários documentos - livros, jogos, DVD e CD - selecionados pela equipa técnica da biblioteca. Desafia-se assim o leitor a explorar o tema que mais gosta mesmo não sabendo com que autor ou realizador se vai deparar.

HORÁRIO | segunda das 18.00h às 23.00h / terça a sexta das 09.30h às 23.00h / sábado das 09.30h às 22.30h
',
        '2023-01-03',
        '2023-01-31',
        'Rua Engenheiro Duarte Pacheco, nº 131 - Maia',
        59,
        'Public'
    ),
    (
        101,
        'Visita Focada — A Cerimónia do Chá',
        'Com Ana Rita Mendes

A primeira cousa com que se agasalham os hóspedes de ordinário entre estas nações ditas é o chá, e se dá a beber não somente uma vez, mas muitas, quando se não dá solenemente, como costumam os japões. Com ele fazem seus cumprimentos e cortesias, agasalhando o hóspede, e enquanto praticam sai (o chá) amiúde, para espertar os espíritos e passarem o tempo com algum acompanhamento decente. (João Rodrigues Tçuzu)

Nesta breve visita vamos conhecer melhor as peças da coleção com relação direta com esta prática, bem como as peculiaridades da mesma. Desde serviços a caixas, de produção oriental ou europeia, o repto está lançado.

Ana Rita Mendes é colaboradora da Divisão Municipal de Museus desde 2018.',
        '2023-01-03',
        '2023-01-03',
        'Rua Nossa Sra de Fátima - Porto',
        205,
        'Public'
    );
INSERT INTO tags (name)
VALUES ('Cultura'),
    ('Desporto'),
    ('Outdoor'),
    ('Indoor'),
    ('Comédia'),
    ('Exposição'),
    ('Música'),
    ('Para Casal'),
    ('Conferência'),
    ('Ciência'),
    ('Família'),
    ('Arte'),
    ('Cinema'),
    ('Teatro'),
    ('Dança'),
    ('Literatura'),
    ('Festas'),
    ('Gastronomia'),
    ('Online'),
    ('Festivais');
INSERT INTO event_tag (event_id, tag_id)
VALUES (1, 3),
    (1, 8),
    (2, 2),
    (2, 19),
    (2, 11),
    (3, 6),
    (3, 4),
    (3, 1),
    (4, 9),
    (5, 7),
    (6, 6),
    (6, 1),
    (7, 17),
    (7, 12),
    (7, 11),
    (8, 6),
    (8, 11),
    (8, 10),
    (9, 9),
    (9, 10),
    (10, 6),
    (10, 11),
    (11, 6),
    (11, 12),
    (12, 7),
    (12, 10),
    (12, 4),
    (13, 12),
    (13, 11),
    (14, 2),
    (15, 1),
    (15, 11),
    (15, 5),
    (16, 16);
INSERT INTO tickets (user_id, event_id, num_of_tickets)
VALUES (3, 1, 5);
INSERT INTO comments (user_id, event_id, content)
VALUES (
        3,
        1,
        'Great job the organizer team has done here!'
    );
INSERT INTO answers (comment_id, user_id, content)
VALUES (1, 45, 'Danke!');
INSERT INTO invites (user_id, event_id)
VALUES (101, 1);
UPDATE cover_images
SET name = 'escape-game.jpeg'
WHERE event_id = 1;
UPDATE cover_images
SET name = 'lionesa.webp'
WHERE event_id = 2;
UPDATE cover_images
SET name = 'spiritus.jpg'
WHERE event_id = 3;
UPDATE cover_images
SET name = 'restarting_life.avif'
WHERE event_id = 4;
UPDATE cover_images
SET name = 'JAZZ-on-SUNDAY-Domingos-Embaixada-do-Porto.jpg'
WHERE event_id = 5;
UPDATE cover_images
SET name = 'berrus-large.png'
WHERE event_id = 6;
UPDATE cover_images
SET name = 'circocoliseu.jpg'
WHERE event_id = 7;
UPDATE cover_images
SET name = 'Sea-life-Porto-Portugal.jpg'
WHERE event_id = 8;
UPDATE cover_images
SET name = 'international-conference.avif'
WHERE event_id = 9;
UPDATE cover_images
SET name = 'DR_Justus_Paulo_Neves_01.webp'
WHERE event_id = 10;
UPDATE cover_images
SET name = 'agenda-expo-walking-maps-fbaup.jpg'
WHERE event_id = 11;
UPDATE cover_images
SET name = 'musicaciencia.jpeg'
WHERE event_id = 12;
UPDATE cover_images
SET name = 'maxresdefault.jpg'
WHERE event_id = 13;
UPDATE cover_images
SET name = '0c0288_535be6562b0e4e4f9aa09179970248d1~mv2.webp'
WHERE event_id = 14;
UPDATE cover_images
SET name = 'b8bc87fac804734c95ab11722c568bc9-large.jpg'
WHERE event_id = 15;
UPDATE cover_images
SET name = '1234803-e7d2f3f8f93c130cf2b97412c7a5702a-r.jpg'
WHERE event_id = 16;
UPDATE cover_images
SET name = 'cerimonia-cha-quickly-travel-interna-910x595.jpg'
WHERE event_id = 17;