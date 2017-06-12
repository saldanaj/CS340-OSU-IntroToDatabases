#Student: Joaquin Saldana
#Assignment 2 / CS340


#1 Find all films with maximum length or minimum rental duration (compared to all other films). 
#In other words let L be the maximum film length, and let R be the minimum rental duration in the table film. You need to find all films that have length L or duration R or both length L and duration R.
#You just need to return attribute film id for this query. 

SELECT film_id 
FROM film 
WHERE rental_duration = (SELECT  MIN(rental_duration) FROM film)
OR length = (SELECT MAX(length) FROM film); 


#2 We want to find out how many of each category of film ED CHASE has started in so return a table with category.name and the count
#of the number of films that ED was in which were in that category order by the category name ascending (Your query should return every category even if ED has been in no films in that category).


SELECT category.name, categoryCount.film_count
FROM category
LEFT JOIN (
    SELECT category.name AS category_name, COUNT(film.film_id) as film_count
    FROM category
    INNER JOIN film_category
    ON film_category.category_id = category.category_id
    INNER JOIN film
    ON film.film_id = film_category.film_id
    INNER JOIN film_actor
    ON film_actor.film_id = film.film_id
    INNER JOIN actor
    ON actor.actor_id = film_actor.actor_id
    WHERE actor.first_name = 'ED' AND actor.last_name = 'CHASE'
    GROUP BY category.name
  ) AS categoryCount
ON categoryCount.category_name = category.name; 


#3 Find the first name, last name and total combined film length of Sci-Fi films for every actor
#That is the result should list the names of all of the actors(even if an actor has not been in any Sci-Fi films)and the total length of Sci-Fi films they have been in.


SELECT actor.first_name, actor.last_name, SUM(film.length)
FROM actor
INNER JOIN film_actor
ON film_actor.actor_id = actor.actor_id
INNER JOIN film
ON film.film_id = film_actor.film_id
INNER JOIN film_category
ON film.film_id = film_category.film_id
INNER JOIN category 
ON film_category.category_id = category.category_id
WHERE category.name = "Sci-Fi" 
GROUP BY actor.first_name, actor.last_name; 



#4 Find the first name and last name of all actors who have never been in a Sci-Fi film


SELECT actor.first_name, actor.last_name FROM actor
INNER JOIN film_actor ON film_actor.actor_id = actor.actor_id
INNER JOIN film ON film.film_id = film_actor.film_id
INNER JOIN film_category ON film_category.film_id = film.film_id
INNER JOIN category ON film_category.category_id = category.category_id
WHERE actor.actor_id NOT IN (SELECT actor.actor_id FROM actor
INNER JOIN film_actor ON film_actor.actor_id = actor.actor_id
INNER JOIN film ON film.film_id = film_actor.film_id
INNER JOIN film_category ON film_category.film_id = film.film_id
INNER JOIN category ON film_category.category_id = category.category_id
WHERE category.name = 'Sci-Fi')
GROUP BY actor.actor_id;





#5 Find the film title of all films which feature both KIRSTEN PALTROW and WARREN NOLTE
#Order the results by title, descending (use ORDER BY title DESC at the end of the query)
#Warning, this is a tricky one and while the syntax is all things you know, you have to think oustide
#the box a bit to figure out how to get a table that shows pairs of actors in movies


SELECT film.title
FROM film
INNER JOIN film_actor AS filmForActorOne
ON filmForActorOne.film_id = film.film_id
INNER JOIN actor AS actorOne
ON actorOne.actor_id = filmForActorOne.actor_id
INNER JOIN film_actor AS filmForActorTwo
ON filmForActorTwo.film_id = film.film_id
INNER JOIN actor as actorTwo
ON actorTwo.actor_id = filmForActorTwo.actor_id
WHERE actorOne.first_name = 'KIRSTEN' AND
      actorOne.last_name = 'PALTROW' AND
      actorTwo.first_name = 'WARREN' AND
      actorTwo.last_name = 'NOLTE'
ORDER BY film.title DESC; 








































