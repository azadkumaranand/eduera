import React, { useState } from 'react';

function AdditionalOption({testId, question_id}) {

    const [question, setQuestion] = useState('');
    const [options, setOptions] = useState(['']);

    const handleOptionChange = (index, e) => {
        const newOptions = [...options];
        newOptions[index] = e.target.value;
        setOptions(newOptions);
    };

    const removeOption = (index) =>{
        const newOptions = [...options];
        newOptions.splice(index, 1);
        setOptions(newOptions);
    }

    const addOption = (e) => {
        e.preventDefault();
        setOptions([...options, '']);
    };
    
  return (
    <div>
        {options.map((option, index) => (
                    <div key={index} className="my-2">
                        <label htmlFor={`option-${index}`} className="form-label">Option {index + 1} {(index+1>1)?<span onClick={()=>{removeOption(index)}} className="badge text-bg-danger">remove</span>:""}</label>
                        <input
                            type="text"
                            className="form-control"
                            name="option[]"
                            value={option}
                            onChange={(e) => handleOptionChange(index, e)}
                        />
                    </div>
                ))}
                <div className="d-flex justify-content-end">
                    <button className="btn btn-dark mt-2" onClick={addOption}>Add Option</button>
                </div>
    </div>
  )
}

export default AdditionalOption
