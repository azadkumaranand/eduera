/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

import './bootstrap';

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


import React from 'react';
import ReactDOM from 'react-dom/client';
import { createRoot } from 'react-dom/client';
import McqCreator from "./components/McqCreator";
import TestRendor from "./components/TestRendor";
import AdditionalOption from "./components/AdditionalOption";


import videojs from 'video.js';
import 'video.js/dist/video-js.css';
import Hls from 'hls.js';

document.addEventListener('DOMContentLoaded', () => {
  const videoElement = document.getElementById('course-video');

  if (videoElement) {
    const videoSrc = videoElement.getAttribute('data-src');

    if (videoElement.canPlayType('application/vnd.apple.mpegurl')) {
      videoElement.src = videoSrc;
    } else if (Hls.isSupported()) {
      const hls = new Hls();
      hls.loadSource(videoSrc);
      hls.attachMedia(videoElement);
    } else {
      console.error('This browser does not support HLS.');
    }

    const player = videojs(videoElement, {
      controls: true,
      autoplay: false,
      preload: 'auto',
      fluid: true,
    });

    // Optional: Disable right-click on the video element
    videoElement.addEventListener('contextmenu', (e) => {
      e.preventDefault();
    });

    // Optional: Custom seek bar functionality
    player.on('seeked', () => {
      console.log('Video has been seeked to: ' + player.currentTime());
    });
  }
});

if (document.querySelector('.mcq-question-container')) {
    // let url = document.querySelector('.mcq-question-container').getAttribute('data-submit-url');
    // let test_id = document.querySelector('.mcq-question-container').getAttribute('data-id');
    // const csrfToken = document.getElementById('mcq-creator-csrf').getAttribute('content');
    const root = ReactDOM.createRoot(document.querySelector('.mcq-question-container'));
    root.render(<McqCreator />);
}
if (document.getElementById('test-form')) {
    const element = document.getElementById('test-form');
    let questions = element.getAttribute('data-question');
    let options = element.getAttribute('data-option');
    let url = element.getAttribute('data-submit-url');
    let userId = element.getAttribute('data-user-id');
    let csrfToken = element.getAttribute('data-csrf');
    console.log(csrfToken);
    // questions = JSON.parse(questions);
    const root = ReactDOM.createRoot(element);
    root.render(<TestRendor questions={questions} options={options} url={url} userId={userId} csrfToken={csrfToken} />);
}
if (document.getElementById('add-option')) {
    let test_id = document.getElementById('add-option').getAttribute('data-test-id');
    let question_id = document.getElementById('add-option').getAttribute('data-q-id');
    // questions = JSON.parse(questions);
    const root = ReactDOM.createRoot(document.getElementById('add-option'));
    root.render(<AdditionalOption testId={test_id} questionId={question_id} />);
}

// const container = document.getElementById('chapter-upload');
// if (container) {
//     const courseId = container.getAttribute('data-course-id');
//     const root = createRoot(container); // createRoot(container!) if you use TypeScript
//     root.render(<ChaptersManagement courseId={courseId} />);
// }
