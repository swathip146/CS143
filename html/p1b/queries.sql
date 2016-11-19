SELECT CONCAT(a.first,' ',a.last)
FROM Actor a, Movie m, MovieActor ma
WHERE m.title='Die Another Day' AND m.id=ma.mid AND ma.aid=a.id;