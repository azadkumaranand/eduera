import React, { useState, useEffect } from 'react';

function TestRender({ questions, options, url, userId, csrfToken, testId }) {
    questions = JSON.parse(questions);
    options = JSON.parse(options);
    const [selectedOption, setSelectedOption] = useState([]);

    // Retrieve or initialize the timer from localStorage
    const initialTime = localStorage.getItem('timeLeft') ? parseInt(localStorage.getItem('timeLeft')) : 30 * 60;
    const [timeLeft, setTimeLeft] = useState(initialTime);

    const optionChange = (e, questionId, optionId, correctanswer) => {
        setSelectedOption((prevSelect) => {
            let questionExist = prevSelect.find(item => item.question_id === questionId);

            if (questionExist) {
                return prevSelect.map(item => 
                    item.question_id === questionId ? { ...item, slectanswer: optionId, correctanswer } : item
                );
            } else {
                return [...prevSelect, { slectanswer: optionId, question_id: questionId, correctanswer }];
            }
        });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        console.log("submit");
        
        let formData = new FormData();
        formData.append('test_id', questions[0].test_id);
        formData.append('user_id', userId);

        selectedOption.forEach((item, index) => {
            formData.append(`question_id[]`, item.question_id);
            formData.append(`selectedans[]`, item.slectanswer);
            formData.append(`correctans[]`, item.correctanswer);
        });

        try {
            let response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: formData,
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            let data = await response.json();
            console.log("Response data:", data);
            // Clear the timer from localStorage on successful submission
            localStorage.removeItem('timeLeft');
        } catch (error) {
            console.log("Something went wrong:", error);
        }
    };

    useEffect(() => {
        console.log(selectedOption);
    }, [selectedOption]);

    useEffect(() => {
        if (timeLeft <= 0) {
            // handleSubmit(new Event('submit'));
            console.log("time out");
        } else {
            localStorage.setItem('timeLeft', timeLeft);
        }

        const timer = setInterval(() => {
            setTimeLeft(prevTime => prevTime - 1);
        }, 1000);

        // Prevent navigation
        const handleBeforeUnload = (event) => {
            event.preventDefault();
            event.returnValue = '';
        };
        window.addEventListener('beforeunload', handleBeforeUnload);

        return () => {
            clearInterval(timer);
            window.removeEventListener('beforeunload', handleBeforeUnload);
        };
    }, [timeLeft]);

    const formatTime = (seconds) => {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        return `${minutes}:${remainingSeconds < 10 ? '0' : ''}${remainingSeconds}`;
    };

    return (
        <div className="container mt-5 mb-3 shadow-sm p-3 rounded-3">
            <div className="position-fixed end-0 top-1">
                Timer: {formatTime(timeLeft)}
            </div>
            <form onSubmit={handleSubmit}>
                {questions.map((question, index) => (
                    <ul key={index} style={{ listStyle: 'none' }}>
                        <li className="fs-5">
                            <input type="hidden" name='question[]' value={`${question.id}`} />
                            <p className="text-secondary">Q{index + 1}. {question.question}</p>
                            <ul style={{ listStyle: 'none' }}>
                                {options.filter(option => option.question_id === question.id).map((option, optionIndex) => {
                                    const isSelected = selectedOption.find(item => item.question_id === question.id)?.slectanswer === option.id;
                                    return (
                                        <li key={optionIndex} className="mb-2">
                                            <label 
                                                htmlFor={`option-${question.id}-${option.id}`}
                                                className={`d-block ${isSelected ? 'bg-success text-light' : ''} col-12 col-md-6 rounded-3 p-2 my-2 border border-dark`}
                                                style={{ cursor: 'pointer' }}
                                            >
                                                {option.option}
                                            </label>
                                            <input 
                                                type="radio" 
                                                id={`option-${question.id}-${option.id}`}
                                                name={`option${question.id}`}
                                                value={option.id}
                                                onChange={(e) => optionChange(e, question.id, option.id, question.answer)}
                                                style={{ display: 'none' }}
                                            />
                                        </li>
                                    );
                                })}
                            </ul>
                        </li>
                    </ul>
                ))}
                <button type="submit" className="btn btn-dark">Submit</button>
            </form>
        </div>
    );
}

export default TestRender;
