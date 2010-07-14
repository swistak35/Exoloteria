class Winner < ActiveRecord::Base
	belongs_to :reward
	validates :nick,		:presence => true
	validates :fraction,	:presence => true
	
end
