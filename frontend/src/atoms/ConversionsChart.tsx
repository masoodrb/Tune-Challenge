import React, { useEffect, useLayoutEffect, useState } from 'react';
import { Line } from 'react-chartjs-2';
import 'chartjs-adapter-date-fns';
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
} from 'chart.js';

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
);

function ConversionsChart({ data }: any) {

  const [windowSize, setWindowSize] = useState({
    width: window.innerWidth,
    height: window.innerHeight,
  });

  useLayoutEffect(() => {
    const handleResize = () => {
      setWindowSize({
        width: window.innerWidth,
        height: window.innerHeight,
      });

    };

    window.addEventListener('resize', handleResize);

    // Clean up the event listener when the component unmounts
    return () => {
      window.removeEventListener('resize', handleResize);
    };
  }, []);

  const chartData = {
    labels: data.map((item: any) => new Date(item.date).toLocaleDateString()),
    datasets: [
      {
        steppedLine: false,
        backgroundColor: 'white',
        borderColor: '#6a5acd',
        label: 'Conversions per Day',
        data: data.map((item: any) => item.conversions),
      },
    ],
  };


  const options = {
    scales: {
      x: {
        display: false
      },
      y: {
        display: false
      }
    },
    plugins: {
      legend: {
        display: false
      }
    }
  };


  return <Line key={windowSize.width} data={chartData} options={options} />;
}

export default ConversionsChart;