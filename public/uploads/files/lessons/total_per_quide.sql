SELECT 
 applied_guide.id, sum(given_replies.value) as total
FROM norma_35.applied_guides as applied_guide
join norma_35.given_replies as given_replies
on given_replies.applied_guide_id = applied_guide.id 
join norma_35.questions  as questions
on questions.id = given_replies.question_id 
 where applied_guide.enterprise_id=1 and applied_guide.guide_id=3
group by applied_guide.id

