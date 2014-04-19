
CREATE TABLE Users(
	uid		INT,
	username 	VARCHAR(16),
	isPrivate	BOOLEAN,
	hashedpw	CHAR(256),
	PRIMARY KEY(uid)
);

CREATE TABLE Post(
	pid		INT,
    	active  	BOOLEAN,
	date		DATE,	
	caption 	VARCHAR(64),
	recipe  	VARCHAR(64),
	img 		BYTEA,
	PRIMARY KEY(pid)
);

CREATE TABLE Comment(
	cid		INT,
	message VARCHAR(1024),
	PRIMARY KEY(cid)
);

CREATE TABLE MakePost(
	uid		INT,
	pid		INT,
	FOREIGN KEY(uid) REFERENCES Users(uid),
	FOREIGN KEY(pid) REFERENCES Post(pid)
);

CREATE TABLE MakeComment(
	uid		INT,
	cid		INT,
  	pid    		INT,
	FOREIGN KEY(uid) REFERENCES Users(uid),
	FOREIGN KEY(cid) REFERENCES Comment(cid),
    	FOREIGN KEY(pid) REFERENCES Post(pid)
);

CREATE TABLE Ingredient(
	ingid	INT,
	amount	FLOAT, 
	units	CHAR(16),
	name	CHAR(64),
	PRIMARY KEY(ingid)
);

CREATE TABLE Stores(
	ingid INT,
	pid INT,
    	FOREIGN KEY(ingid) REFERENCES Ingredient(ingid),
    	FOREIGN KEY(pid) REFERENCES Post(pid)
);

INSERT INTO Users VALUES
    (15, 'js7', FALSE, 'lolwat'),
    (16, 'TheTerminator', TRUE, 'imapassword'),
    (17, 'johndoe', FALSE, 'lol'),
    (18, 'myname', TRUE, 'wat'),
    (19, 'blah', FALSE, 'lowat');
	
INSERT INTO Post VALUES
    (1, TRUE, '2013-08-09', 'This recipe is great!', 'Bake at 350'),
    (2, TRUE, '2013-11-04', 'Delicious', 'Just put it in the microwave'),
    (3, FALSE, '2013-11-05', 'APPRECIATE MY PICTURES OF FOOD', 'BURN EVERYTHING');

INSERT INTO Comment VALUES
    (40, 'Indeed, it looks delicious'),
    (41, 'That is a great recipe!'),
    (42, 'I APPRECIATE THIS'),
    (43, 'I also think it looks delicious'),
    (44, 'CAPS LOCK IS BEST LOCK');
	
INSERT INTO MakePost VALUES
    (19, 1),
    (15, 2),
    (16, 3);

INSERT INTO MakeComment VALUES
    (19, 40, 2),
    (17, 41, 1),
    (17, 42, 3),
    (18, 43, 2),
    (16, 44, 3);
	
INSERT INTO Ingredient VALUES
    (200, 45, 'TBSP', 'Sugar'),
    (201, 3, 'TSP', 'Sugar'),
    (202, 2, 'OZ', 'Beef'),
    (203, 1, 'TBSP', 'Butter'),
    (204, 2.5, 'TSP', 'Olive Oil');

INSERT INTO Stores VALUES
    (200, 1),
    (201, 2),
    (203, 2),
    (202, 3),
    (204, 1);

--Searches for the names of ingredients in the posts and returns the post id. Replace tomato with php var.
SELECT pid, name 
FROM Ingredient, Stores 
WHERE name = ‘tomato’;
	
--Counts number of ingredients for all posts, only shows those with 2 ingredients
--to search a number put in by a user: use php, put below SQL query in a String, concatenate, use php var in place of '2'
SELECT COUNT(Stores.ingid) as count1, pid 
FROM Ingredient, Stores
WHERE Ingredient.ingid=Stores.ingid 
GROUP BY pid
HAVING COUNT(Stores.ingid) = 2;

--makes a view for "active" posts
CREATE VIEW activePosts AS SELECT * FROM Post WHERE active=TRUE;
SELECT * FROM ACTIVEPOSTS;

--view for dashboard/feed; "date" included to check if OrderBY works, won't actually be shown in feed; need to also include image
CREATE VIEW currentFeedPosts AS SELECT post.pid,caption,date,makepost.uid,username FROM Post,MakePost,Users WHERE active=TRUE AND post.pid=makepost.pid AND users.uid=makepost.uid ORDER BY date;
SELECT * FROM currentFeedPosts;

--creats an index on Users for 'username', searches for usernames with an "m" in it 
CREATE INDEX usernamesearch ON Users(username);
SELECT username FROM users WHERE username LIKE '%m%';

--Get all posts from User 15:
WITH Userposts AS(
SELECT Users.uid, pid
FROM (Users JOIN MakePost ON (Users.uid = MakePost.uid))
WHERE Users.uid = 15)
SELECT Userposts.uid, Userposts.pid, active, date, caption, recipe, imgpath
FROM (Userposts JOIN Post ON (Userposts.pid = Post.pid))
ORDER BY date DESC;

--Get all comments from Post 2:
WITH Postcomments AS(
SELECT Post.pid, cid, uid
FROM (Post JOIN MakeComment ON (Post.pid = MakeComment.pid))
WHERE Post.pid = 2)
SELECT Postcomments.pid, Users.username, Postcomments.uid, message
FROM (Postcomments JOIN Comment ON (Postcomments.cid = Comment.cid)), Users
WHERE Users.uid = Postcomments.uid;

--Get all ingredients from Post 2:
WITH Postings AS(
SELECT Post.pid, ingid
FROM (Post JOIN Stores ON (Post.pid = Stores.pid))
WHERE Post.pid = 2)
SELECT Postings.pid, Postings.ingid, name, amount, units 
FROM (Postings JOIN Ingredient ON (Postings.ingid = Ingredient.ingid));

--This function works on the database, but doesn't work on SQLFiddle
CREATE FUNCTION erase_duplicate3() RETURNS TRIGGER AS $_$
BEGIN
	DELETE FROM Users WHERE Users.username = NEW.username
	AND Users.uid = NEW.uid;
	RETURN NEW;
END $_$ LANGUAGE 'plpgsql';
--Make sure to create the above function before creating this trigger
CREATE TRIGGER UsernameExists
AFTER INSERT ON Users
FOR EACH ROW
EXECUTE PROCEDURE erase_duplicate3(NEW);

--checks image size and adds max constraint
ALTER TABLE Post
ADD CHECK (img>0) 
ADD CONSTRAINT checkImgSize (img>0 AND img<16785346)

--replaces the old active status with the new for posts
CREATE PROCEDURE OldPost (
IN newActive BOOLEAN,
IN oldActive BOOLEAN
)
UPDATE Post
SET active = newActive 
WHERE active = oldActive;
