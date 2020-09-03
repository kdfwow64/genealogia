
import sys
from lineage import Lineage
l = Lineage()

file1 = "resources/" + sys.argv[1]
file2 = "resources/" + sys.argv[2]


      
user662 = l.create_individual('User662', file1)
user663 = l.create_individual('User663', file2)
discordant_snps = l.find_discordant_snps(user662, user663, save_output=True)
len(discordant_snps.loc[discordant_snps['chrom'] != 'MT'])
results = l.find_shared_dna([user662, user663], cM_threshold=0.75, snp_threshold=1100)