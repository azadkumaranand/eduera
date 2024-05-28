import React, { useState, useEffect } from "react";

function McqCreator({ url, csrfToken, testId }) {
    const [question, setQuestion] = useState("");
    const [options, setOptions] = useState([""]);
    const [correctanswer, setcorrectanswer] = useState("");

    const handleQuestionChange = (e) => {
        setQuestion(e.target.value);
    };

    useEffect(() => {
        console.log(correctanswer);
    }, [correctanswer]);

    const handleOptionChange = (index, e) => {
        const newOptions = [...options];
        newOptions[index] = e.target.value;
        setOptions(newOptions);
    };

    const removeOption = (index) => {
        const newOptions = [...options];
        newOptions.splice(index, 1);
        setOptions(newOptions);
    };

    const addOption = (e) => {
        e.preventDefault();
        setOptions([...options, ""]);
    };

    // const handleSubmit = async (e) => {
    //     e.preventDefault();
    //     let formData = new FormData();
    //     formData.append('question', question);
    //     formData.append('test_id', testId);
    //     formData.append('no_of_option', options.length);
    //     formData.append('correctanswer', correctanswer);
    //     options.forEach((option, index) => {
    //         formData.append(`option[${index}]`, option);
    //     });

    //     try {
    //         let response = await fetch(url, {
    //             method: 'POST',
    //             headers: {
    //                 'X-CSRF-TOKEN': csrfToken,
    //             },
    //             body: formData,
    //         });

    //         if (!response.ok) {
    //             throw new Error(`HTTP error! status: ${response.status}`);
    //         }

    //         let data = await response.json();
    //         console.log("Response data:", data);
    //     } catch (error) {
    //         console.log("Something went wrong:", error);
    //     }
    // };

    return (
        <div>
            <div className="my-2">
                <label htmlFor="question" className="form-label">
                    Question
                </label>
                <input
                    type="text"
                    className="form-control"
                    name="question"
                    value={question}
                    onChange={handleQuestionChange}
                />
            </div>
            {options.map((option, index) => (
                <div key={index} className="my-2">
                    <label htmlFor={`option-${index}`} className="form-label">
                        Option {index + 1}{" "}
                        {index + 1 > 1 ? (
                            <span
                                onClick={() => {
                                    removeOption(index);
                                }}
                                className="badge text-bg-danger"
                            >
                                remove
                            </span>
                        ) : (
                            ""
                        )}
                    </label>
                    <input
                        type="text"
                        className="form-control"
                        name="option[]"
                        value={option}
                        onChange={(e) => handleOptionChange(index, e)}
                    />
                </div>
            ))}
            {options.length > 1 && (
                <div className="my-2">
                    <label htmlFor="correctanswer" className="form-label">
                        Choose Correct answer
                    </label>
                    <select
                        name="correctanswer"
                        id="correctanswer"
                        onChange={(e) => {
                            setcorrectanswer(e.target.value);
                        }}
                        className="form-control"
                    >
                        {options.map((option, index) => (
                            <option key={index} value={`${index}`}>
                                {option}
                            </option>
                        ))}
                    </select>
                </div>
            )}

            <div className="d-flex justify-content-end">
                <button className="btn btn-dark mt-2" onClick={addOption}>
                    Add Option
                </button>
            </div>
            <div className="d-flex justify-content-end">
                <button type="submit" className="btn btn-dark mt-2">
                    Submit
                </button>
            </div>
        </div>
    );
}

export default McqCreator;
