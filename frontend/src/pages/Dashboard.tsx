import { FiMenu } from 'react-icons/fi';
import { AiOutlineSearch } from 'react-icons/ai';
import UsersGrid from '../organisms/UsersGrid';
import { NavComponent } from '../molecules/NavComponent';


export function Dashboard() {

  return (
    <>
      <NavComponent />
      <div className='mx-auto px-4 m-4'>
          <UsersGrid />
      </div>

    </>
  );
}
