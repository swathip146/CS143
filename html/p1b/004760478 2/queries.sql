-- Give me the names of all the actors in the movie 'Die Another Day'. Please also make sure actor names are in this format:  <firstname> <lastname>   (seperated by single space, **very important**)
select concat(first," ",last) as ActorName from Actor a, MovieActor ma, Movie m where m.title = "Die Another Day" and m.id = ma.mid and a.id = ma.aid;

-- Give me the count of all the actors who acted in multiple movies.
select count(*) from (select count(mid) from MovieActor group by aid having count(mid) > 1) a;

-- NEW QUERY : Give the top 5 actors who've starred in the maximum number of movies
select concat(first," ",last), count(mid) as c from Actor a join MovieActor ma on a.id = ma.aid group by aid order by c desc limit 5;