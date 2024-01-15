import { AiOutlineSearch } from "react-icons/ai";
import { FiMenu } from "react-icons/fi";

export function NavComponent() {

  return (
    <>
      <div className="bg-blue-800 text-white p-4 flex justify-between items-center shadow-2xl">
        <button className="flex items-center">
          <FiMenu className="h-6 w-6 mr-2 text-white" />
          <span className='mx-4 text-lg'>User Dashboard</span>
        </button>
        <div className="flex items-center">
          <div className="bg-custom-blue rounded flex items-center p-1 justify-start">
            <AiOutlineSearch className="h-5 w-5 mx-2 text-white" />
            <input className="bg-transparent focus:outline-none text-white mx-2 w-40" type="text" placeholder="Search.." />
          </div>
        </div>
      </div>
    </>
  )
}
