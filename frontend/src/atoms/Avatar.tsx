import React, { memo } from 'react'

type Props = {
  imgUrl: string;
  name: string;
} 

const Avatar = memo(({ imgUrl, name }: Props) => {

  const hue1 = Math.floor(Math.random() * 210) + 60;
  const hue2 = Math.floor(Math.random() * 80) + 60;

  const background = `radial-gradient(circle, hsl(${hue1}, 100%, 50%), hsl(${hue2}, 100%, 50%))`;

  return (
    <>
      {imgUrl ? (
        <img src={imgUrl} alt="" className="w-full h-full rounded-full object-cover" />
      ) : (
        <div
          style={{ background }}
          className="w-full h-full rounded-full flex items-center justify-center text-white text-xl font-bold"
        >
          {name[0].toUpperCase()}
        </div>
      )}
    </>
  );
});

export {Avatar} ;